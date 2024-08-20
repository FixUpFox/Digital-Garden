<?php
/**
 * Digital Garden Custom Post Type Class
 *
 * This class handles the registration of the custom post type "note".
 */

class Digital_Garden_CPT {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
	}

	/**
	 * Register the custom post type.
	 */
	public static function register_post_type() {
		// Set up labels for the custom post type
		$labels = array(
			'name'                  => _x( 'Notes', 'Post type general name', 'digital-garden' ),
			'singular_name'         => _x( 'Note', 'Post type singular name', 'digital-garden' ),
			'menu_name'             => _x( 'Notes', 'Admin Menu text', 'digital-garden' ),
			'name_admin_bar'        => _x( 'Note', 'Add New on Toolbar', 'digital-garden' ),
			'add_new'               => __( 'Add New', 'digital-garden' ),
			'add_new_item'          => __( 'Add New Note', 'digital-garden' ),
			'new_item'              => __( 'New Note', 'digital-garden' ),
			'edit_item'             => __( 'Edit Note', 'digital-garden' ),
			'view_item'             => __( 'View Note', 'digital-garden' ),
			'all_items'             => __( 'All Notes', 'digital-garden' ),
			'search_items'          => __( 'Search Notes', 'digital-garden' ),
			'parent_item_colon'     => __( 'Parent Notes:', 'digital-garden' ),
			'not_found'             => __( 'No notes found.', 'digital-garden' ),
			'not_found_in_trash'    => __( 'No notes found in Trash.', 'digital-garden' ),
			'featured_image'        => _x( 'Note Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'digital-garden' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'digital-garden' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'digital-garden' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'digital-garden' ),
			'archives'              => _x( 'Note archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'digital-garden' ),
			'insert_into_item'      => _x( 'Insert into note', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'digital-garden' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this note', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'digital-garden' ),
			'filter_items_list'     => _x( 'Filter notes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'digital-garden' ),
			'items_list_navigation' => _x( 'Notes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'digital-garden' ),
			'items_list'            => _x( 'Notes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'digital-garden' ),
		);

		// Set up rewrites for the custom post type
		$rewrite = array(
			'slug'       => 'note',
			'with_front' => true,
			'pages'      => false,
			'feeds'      => true,
		);

		// Set up arguments for the custom post type
		$args = array(
			'label'               => __( 'Note', 'digital-garden' ),
			'description'         => __( 'Digital Garden Notes', 'digital-garden' ),
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-index-card',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'query_var'           => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'show_in_rest'        => true,
			'can_export'          => true,
			'exclude_from_search' => false,
			'template'            => array(
				array(
					'core/paragraph',
					array(
						'placeholder' => 'Grow your garden 🏡',
					),
				),
			),
		);

		// Register the custom post type
		register_post_type( 'note', $args );
	}
}

Digital_Garden_CPT::init();
