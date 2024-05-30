<?php
/**
 * Digital Garden Metabox Class
 *
 * This class handles the creation and saving of a metabox for the note post type.
 */

class Digital_Garden_Metabox {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
		add_action( 'save_post_note', array( __CLASS__, 'save_meta_box' ) );
	}

	/**
	 * Add the meta box.
	 */
	public static function add_meta_box() {
		add_meta_box(
			'note_completeness',
			__( 'Note Completeness', 'digital-garden' ),
			array( __CLASS__, 'render_meta_box' ),
			'note',
			'side',
			'default'
		);
	}

	/**
	 * Render the meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public static function render_meta_box( $post ) {
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'digital_garden_save_meta_box', 'digital_garden_meta_box_nonce' );

		// Retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_note_completeness', true );

		?>
		<label for="digital_garden_note_completeness"><?php esc_html_e( 'Completeness:', 'digital-garden' ); ?></label>
		<select name="digital_garden_note_completeness" id="digital_garden_note_completeness" class="postbox">
			<option value="seedling" <?php selected( $value, 'seedling' ); ?>><?php esc_html_e( 'Seedling', 'digital-garden' ); ?></option>
			<option value="sprout" <?php selected( $value, 'sprout' ); ?>><?php esc_html_e( 'Sprout', 'digital-garden' ); ?></option>
			<option value="sapling" <?php selected( $value, 'sapling' ); ?>><?php esc_html_e( 'Sapling', 'digital-garden' ); ?></option>
			<option value="evergreen" <?php selected( $value, 'evergreen' ); ?>><?php esc_html_e( 'Evergreen', 'digital-garden' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Save the meta box data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public static function save_meta_box( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['digital_garden_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['digital_garden_meta_box_nonce'], 'digital_garden_save_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Sanitize user input.
		$new_value = isset( $_POST['digital_garden_note_completeness'] ) ? sanitize_text_field( $_POST['digital_garden_note_completeness'] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, '_note_completeness', $new_value );
	}
}

// Initialize the class.
Digital_Garden_Metabox::init();
