<?php
/**
 * Digital Garden Hashtags Class
 *
 * This class handles converting hashtags in the content to tags for the note post type.
 */

class Digital_Garden_Hashtags {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_action( 'save_post_note', array( __CLASS__, 'process_hashtags_to_tags' ), 10, 2 );
	}

	/**
	 * Process hashtags in the post content and convert them to tags.
	 *
	 * @param int     $post_id The ID of the post being saved.
	 * @param WP_Post $post The post object.
	 */
	public static function process_hashtags_to_tags( $post_id, $post ) {
		// Check if this is an autosave.
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

		// Get the post content.
		$content = $post->post_content;

		// Find all hashtags in the content.
		preg_match_all( '/#(\w+)/', $content, $matches );

		if ( ! empty( $matches[1] ) ) {
			// Remove duplicates and sanitize tags.
			$tags = array_map( 'sanitize_text_field', array_unique( $matches[1] ) );

			// Set the note tags.
			wp_set_post_terms( $post_id, $tags, 'note_tag', true );
		}
	}
}

// Initialize the class.
Digital_Garden_Hashtags::init();
