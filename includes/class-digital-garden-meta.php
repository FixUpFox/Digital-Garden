<?php
/**
 * Digital Garden Meta Class
 *
 * This class handles the registration of custom post meta for the note post type.
 */

class Digital_Garden_Meta {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_meta' ) );
	}

	/**
	 * Register the custom post meta.
	 */
	public static function register_post_meta() {
		register_post_meta(
			'note',
			'_note_completeness',
			array(
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => true,
				'default'      => 'seedling',
				'description'  => __( 'Note Completeness', 'digital-garden' ),
			)
		);
	}
}

// Initialize the class.
Digital_Garden_Meta::init();
