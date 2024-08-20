<?php
/**
 * Plugin Name: Digital Garden
 * Description: A plugin to create a digital garden with notes and tags.
 * Version: 1.0.0
 * Author: wolfpaw
 * Text Domain: digital-garden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define plugin version
define( 'DIGITAL_GARDEN_VERSION', '1.0.0' );

// Include the necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-cpt.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-taxonomy.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-meta.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-metabox.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-hashtags.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-frontend.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-bidirectional-linking.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-block.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-digital-garden-notes-list-table.php';

// Initialize the custom post type, taxonomy, meta, and other classes
add_action( 'init', array( 'Digital_Garden_CPT', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Taxonomy', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Meta', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Metabox', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Hashtags', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Frontend', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Settings', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Bidirectional_Linking', 'init' ) );
add_action( 'init', array( 'Digital_Garden_Block', 'init' ) );

// Activation and deactivation hooks
register_activation_hook( __FILE__, 'digital_garden_activate' );
register_deactivation_hook( __FILE__, 'digital_garden_deactivate' );

// Activation function
function digital_garden_activate() {
	// Register custom post types and taxonomies
	Digital_Garden_CPT::init();
	Digital_Garden_Taxonomy::init();
	Digital_Garden_Meta::init();
	Digital_Garden_Metabox::init();
	Digital_Garden_Hashtags::init();
	Digital_Garden_Frontend::init();
	Digital_Garden_Settings::init();
	Digital_Garden_Bidirectional_Linking::init();
	Digital_Garden_Block::init();

	// Create the Digital Garden page
	$page_id = get_option( 'digital_garden_page_id' );

	if ( ! $page_id || ! get_post( $page_id ) ) {
		$page = array(
			'post_title'   => 'Digital Garden',
			'post_name'    => 'garden',
			'post_content' => '<!-- wp:digital-garden/archive /-->',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => 1,
		);

		$page_id = wp_insert_post( $page );
		update_option( 'digital_garden_page_id', $page_id );
	}

	// Flush rewrite rules
	flush_rewrite_rules();
}

// Deactivation function
function digital_garden_deactivate() {
	// Flush rewrite rules
	flush_rewrite_rules();
}
