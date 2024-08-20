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

// Activation and deactivation hooks
register_activation_hook( __FILE__, 'digital_garden_activate' );
register_deactivation_hook( __FILE__, 'digital_garden_deactivate' );

// Activation function
function digital_garden_activate() {
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
