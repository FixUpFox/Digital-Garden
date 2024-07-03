<?php

class Digital_Garden_Bidirectional_Linking {

	public static function init() {
		add_action( 'save_post_note', array( __CLASS__, 'detect_links' ), 10, 2 );
		add_filter( 'the_content', array( __CLASS__, 'display_linked_from_section' ) );
		add_filter( 'the_content', array( __CLASS__, 'convert_double_brackets_to_links' ) );
	}

	/**
	 * Detect and save bidirectional links when a note is saved.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public static function detect_links( $post_id, $post ) {
		// Check if this is an autosave or a revision.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Ensure the post content is set.
		if ( ! isset( $post->post_content ) ) {
			return;
		}

		// Process bidirectional links.
		self::process_links( $post_id, $post->post_content );

		// Process double bracket links.
		self::process_double_brackets( $post_id, $post->post_content );
	}


	/**
	 * Process bidirectional links.
	 *
	 * @param int    $post_id   Post ID.
	 * @param string $content   Post content.
	 */
	private static function process_links( $post_id, $content ) {
		// Get existing linked posts.
		$existing_linked_posts = get_post_meta( $post_id, '_linked_from', false );

		// Collect new links from content.
		$new_linked_posts = array();

		if ( preg_match_all( '/href="([^"]+)"/', $content, $matches ) ) {
			foreach ( $matches[1] as $url ) {
				$linked_post_id = url_to_postid( $url );

				if ( $linked_post_id && get_post_type( $linked_post_id ) === 'note' ) {
					$new_linked_posts[] = $linked_post_id;
				}
			}
		}

		// Remove links that no longer exist.
		if ( ! empty( $existing_linked_posts ) ) {
			foreach ( $existing_linked_posts as $existing_linked_post_id ) {
				if ( ! in_array( $existing_linked_post_id, $new_linked_posts ) ) {
					delete_post_meta( $existing_linked_post_id, '_linked_from', $post_id );
				}
			}
		}

		// Add new links.
		foreach ( $new_linked_posts as $new_linked_post_id ) {
			if ( ! metadata_exists( 'post', $new_linked_post_id, '_linked_from' ) || ! in_array( $post_id, get_post_meta( $new_linked_post_id, '_linked_from' ) ) ) {
				add_post_meta( $new_linked_post_id, '_linked_from', $post_id, false );
			}
		}
	}


	/**
	 * Display "Linked From" section in the note content.
	 *
	 * @param string $content Post content.
	 * @return string Modified post content.
	 */
	public static function display_linked_from_section( $content ) {
		// Only apply to 'note' post type.
		if ( get_post_type() !== 'note' ) {
			return $content;
		}

		// Get the current post ID.
		$post_id = get_the_ID();

		// Get the notes that link to this note.
		$linked_from = get_post_meta( $post_id, '_linked_from', false );

		if ( ! empty( $linked_from ) ) {
			$linked_from = array_unique( $linked_from ); // Ensure there are no duplicate entries.
			$content    .= '<h3>' . __( 'Linked From', 'digital-garden' ) . '</h3><ul>';

			foreach ( $linked_from as $linked_post_id ) {
				$content .= '<li><a href="' . get_permalink( $linked_post_id ) . '">' . get_the_title( $linked_post_id ) . '</a></li>';
			}

			$content .= '</ul>';
		}

		return $content;
	}

	/**
	 * Convert double bracket links to actual links in the post content.
	 *
	 * @param string $content Post content.
	 * @return string Modified post content.
	 */
	public static function convert_double_brackets_to_links( $content ) {
		// Only apply to 'note' post type.
		if ( get_post_type() !== 'note' ) {
			return $content;
		}

		// Handle double-bracket links.
		if ( preg_match_all( '/\[\[([^\]]+)\]\]/', $content, $matches ) ) {
			foreach ( $matches[1] as $match ) {
				$normalized_slug = sanitize_title( strtolower( $match ) );
				$note            = get_page_by_path( $normalized_slug, OBJECT, 'note' );

				// If the note doesn't exist, create a draft note.
				if ( ! $note ) {
					$note_id   = wp_insert_post(
						array(
							'post_title'  => $match,
							'post_name'   => $normalized_slug,
							'post_type'   => 'note',
							'post_status' => 'draft',
						)
					);
					$note_link = get_permalink( $note_id );

					// Add backlink to the created note.
					add_post_meta( $note_id, '_linked_from', get_the_ID(), false );
				} else {
					$note_link = get_permalink( $note->ID );
					$note_id   = $note->ID;

					// Add backlink to the existing note if not already added.
					if ( ! metadata_exists( 'post', $note_id, '_linked_from' ) || ! in_array( get_the_ID(), get_post_meta( $note_id, '_linked_from' ) ) ) {
						add_post_meta( $note_id, '_linked_from', get_the_ID(), false );
					}
				}

				// Replace [[word]] with a link to the note.
				$content = str_replace(
					'[[' . $match . ']]',
					'<a href="' . esc_url( $note_link ) . '" class="digital-garden-note-link" data-note-id="' . esc_attr( $note_id ) . '">' . esc_html( $match ) . '</a>',
					$content
				);
			}
		}

		// Handle regular links.
		if ( preg_match_all( '/<a href="([^"]+)">([^<]+)<\/a>/', $content, $matches ) ) {
			foreach ( $matches[1] as $index => $url ) {
				$note_id = url_to_postid( $url );
				if ( $note_id && get_post_type( $note_id ) === 'note' ) {
					$link_html     = $matches[0][ $index ];
					$new_link_html = str_replace(
						'<a ',
						'<a class="digital-garden-regular-link" data-note-id="' . esc_attr( $note_id ) . '" ',
						$link_html
					);
					$content       = str_replace( $link_html, $new_link_html, $content );
				}
			}
		}

		return $content;
	}

	/**
	 * Process double bracket links.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $content Post content.
	 */
	public static function process_double_brackets( $post_id, $content ) {
		// Find all instances of [[word]] in the content.
		if ( preg_match_all( '/\[\[([^\]]+)\]\]/', $content, $matches ) ) {
			foreach ( $matches[1] as $match ) {
				$normalized_slug = sanitize_title( strtolower( $match ) );
				$note            = get_page_by_path( $normalized_slug, OBJECT, 'note' );

				// If the note doesn't exist, create a draft note.
				if ( ! $note ) {
					$note_id = wp_insert_post(
						array(
							'post_title'  => $match,
							'post_name'   => $normalized_slug,
							'post_type'   => 'note',
							'post_status' => 'draft',
						)
					);
				} else {
					$note_id = $note->ID;
				}

				// Add backlink to the created or existing note.
				if ( ! metadata_exists( 'post', $note_id, '_linked_from' ) || ! in_array( $post_id, get_post_meta( $note_id, '_linked_from' ) ) ) {
					add_post_meta( $note_id, '_linked_from', $post_id, false );
				}
			}
		}
	}
}

Digital_Garden_Bidirectional_Linking::init();
