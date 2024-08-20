<?php

use function Digital_Garden\completeness_list;

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
		register_post_meta(
			'note',
			'_note_completeness',
			array(
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => true,
				'default'      => array_key_first( completeness_list() ),
				'description'  => __( 'Note Completeness', 'digital-garden' ),
			)
		);
	}
}
