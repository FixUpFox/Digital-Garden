<?php
/**
 * Digital Garden Frontend Class
 *
 * This class handles frontend modifications, including converting hashtags to links
 * and displaying timestamps for notes.
 */

class Digital_Garden_Frontend {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_filter( 'the_content', array( __CLASS__, 'convert_hashtags_to_links' ) );
		add_filter( 'the_content', array( __CLASS__, 'display_timestamps' ) );
		add_action( 'template_redirect', array( __CLASS__, 'track_recently_viewed' ) );
		add_filter( 'the_content', array( __CLASS__, 'display_breadcrumbs' ) );
	}

	/**
	 * Convert hashtags in the content to links.
	 *
	 * @param string $content The post content.
	 * @return string The modified post content.
	 */
	public static function convert_hashtags_to_links( $content ) {
		// Only apply to 'note' post type
		if ( get_post_type() !== 'note' ) {
			return $content;
		}

		// Find all hashtags in the content
		$content = preg_replace_callback(
			'/#(\w+)/',
			function ( $matches ) {
				$tag      = sanitize_title( $matches[1] );

				// Get the tag term
				$tag_term = get_term_by( 'name', $tag, 'note_tag' );

				if ( is_wp_error( $tag_term ) || ! is_a( $tag_term, WP_Term::class ) ) {
					return $matches[0];
				}

				// Build the URL
				$url = add_query_arg(
					[ 'tags' => $tag_term->term_id ],
					get_the_permalink( get_option( 'digital_garden_page_id' ) )
				);

				return '<a href="' . esc_url( $url ) . '">#' . esc_html( $matches[1] ) . '</a>';
			},
			$content
		);

		return $content;
	}

	/**
	 * Display timestamps in the content.
	 *
	 * @param string $content The post content.
	 * @return string The modified post content.
	 */
	public static function display_timestamps( $content ) {
		// Only apply to 'note' post type
		if ( get_post_type() !== 'note' ) {
			return $content;
		}

		// Display "last edited" timestamp
		if ( get_option( 'digital_garden_display_last_edited' ) ) {
			$last_edited = get_the_modified_date();
			$content    .= '<p><em>Last edited on: ' . esc_html( $last_edited ) . '</em></p>';
		}

		// Display "first created" timestamp
		if ( get_option( 'digital_garden_display_first_created' ) ) {
			$first_created = get_the_date();
			$content      .= '<p><em>First created on: ' . esc_html( $first_created ) . '</em></p>';
		}

		return $content;
	}

	/**
	 * Track recently viewed notes
	 */
	public static function track_recently_viewed() {
		if ( ! is_singular( 'note' ) ) {
			return;
		}

		if ( ! session_id() ) {
			session_start();
		}

		$note_id         = get_the_ID();
		$recently_viewed = isset( $_SESSION['recently_viewed_notes'] ) ? $_SESSION['recently_viewed_notes'] : array();
		$key             = array_search( $note_id, $recently_viewed, true );

		// Remove the note if it's already in the array.
		if ( false !== $key ) {
			unset( $recently_viewed[ $key ] );
		}

		// Add the note to the beginning of the array.
		array_unshift( $recently_viewed, $note_id );

		// Limit the number of steps in the breadcrumb trail.
		$max_steps       = get_option( 'digital_garden_breadcrumb_steps', 5 );
		$recently_viewed = array_slice( $recently_viewed, 0, $max_steps );

		// Save the updated array back to the session.
		$_SESSION['recently_viewed_notes'] = $recently_viewed;
	}

	/**
	 * Display breadcrumbs in the content.
	 *
	 * @param string $content The post content.
	 * @return string The modified post content.
	 */
	public static function display_breadcrumbs( $content ) {
		// Check if breadcrumbs are enabled.
		if ( ! get_option( 'digital_garden_enable_breadcrumbs', 1 ) ) {
			return $content;
		}

		if ( ! is_singular( 'note' ) ) {
			return $content;
		}

		if ( ! session_id() ) {
			session_start();
		}

		$recently_viewed = isset( $_SESSION['recently_viewed_notes'] ) ? array_reverse( $_SESSION['recently_viewed_notes'] ) : array();

		if ( ! empty( $recently_viewed ) ) {
			$breadcrumbs = '<nav class="digital-garden-breadcrumbs"><div class="digital-garden-breadcrumb-title">' . __( 'Recently Viewed Notes', 'digital-garden' ) . '</div><ul>';

			foreach ( $recently_viewed as $note_id ) {
				if ( get_the_ID() !== $note_id ) {
					$breadcrumbs .= '<li><a href="' . get_permalink( $note_id ) . '">' . get_the_title( $note_id ) . '</a></li>';
				} else {
					$breadcrumbs .= '<li>' . get_the_title( $note_id ) . '</li>';
				}
			}

			$breadcrumbs .= '</ul></nav>';
		}

		$breadcrumbs .= '<nav class="digital-garden-breadcrumbs-placeholder"></nav>';

		return $breadcrumbs . $content;
	}
}

// Initialize the class.
Digital_Garden_Frontend::init();
