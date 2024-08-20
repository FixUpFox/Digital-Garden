<?php
/**
 * Digital Garden Taxonomy Class
 *
 * This class handles the registration of the custom taxonomy "note_tag" for the note post type.
 */

class Digital_Garden_Taxonomy {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
	}

	/**
	 * Register the custom taxonomy.
	 */
	function register_taxonomy() {
		// Set up labels for the custom taxonomy
		$labels = array(
			'name'                       => _x( 'Note Tags', 'taxonomy general name', 'digital-garden' ),
			'singular_name'              => _x( 'Note Tag', 'taxonomy singular name', 'digital-garden' ),
			'search_items'               => __( 'Search Note Tags', 'digital-garden' ),
			'popular_items'              => __( 'Popular Note Tags', 'digital-garden' ),
			'all_items'                  => __( 'All Note Tags', 'digital-garden' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Note Tag', 'digital-garden' ),
			'update_item'                => __( 'Update Note Tag', 'digital-garden' ),
			'add_new_item'               => __( 'Add New Note Tag', 'digital-garden' ),
			'new_item_name'              => __( 'New Note Tag Name', 'digital-garden' ),
			'separate_items_with_commas' => __( 'Separate note tags with commas', 'digital-garden' ),
			'add_or_remove_items'        => __( 'Add or remove note tags', 'digital-garden' ),
			'choose_from_most_used'      => __( 'Choose from the most used note tags', 'digital-garden' ),
			'not_found'                  => __( 'No note tags found.', 'digital-garden' ),
			'menu_name'                  => __( 'Note Tags', 'digital-garden' ),
		);

		// Set up arguments for the custom taxonomy
		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'note-tag' ),
			'show_in_rest'          => true,
		);

		// Register the custom taxonomy
		register_taxonomy( 'note_tag', 'note', $args );
	}
}

// Initialize the class.
Digital_Garden_Taxonomy::init();
