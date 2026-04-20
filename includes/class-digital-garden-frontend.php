<?php
/**
 * Digital Garden Frontend Class.
 *
 * @package DigitalGarden
 */

/**
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
	}

	/**
	 * Convert hashtags in the content to links.
	 *
	 * @param string $content The post content.
	 * @return string The modified post content.
	 */
	public static function convert_hashtags_to_links( $content ) {
		// Only apply to 'note' post type.
		if ( get_post_type() !== 'note' ) {
			return $content;
		}

		// Find all hashtags in the content.
		$content = preg_replace_callback(
			'/#(\w+)/',
			function ( $matches ) {
				$tag = sanitize_title( $matches[1] );

				// Get the tag term.
				$tag_term = get_term_by( 'name', $tag, 'note_tag' );

				if ( is_wp_error( $tag_term ) || ! is_a( $tag_term, WP_Term::class ) ) {
					return $matches[0];
				}

				// Build the URL.
				$url = add_query_arg(
					array( 'tags' => $tag_term->term_id ),
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
		// Only apply to 'note' post type.
		if ( get_post_type() !== 'note' ) {
			return $content;
		}

		// Display "last edited" timestamp.
		if ( get_option( 'digital_garden_display_last_edited' ) ) {
			$last_edited = get_the_modified_date();
			$content    .= '<p><em>Last edited on: ' . esc_html( $last_edited ) . '</em></p>';
		}

		// Display "first created" timestamp.
		if ( get_option( 'digital_garden_display_first_created' ) ) {
			$first_created = get_the_date();
			$content      .= '<p><em>First created on: ' . esc_html( $first_created ) . '</em></p>';
		}

		return $content;
	}


}

// Initialize the class.
Digital_Garden_Frontend::init();
