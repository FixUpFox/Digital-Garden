<?php
/**
 * Plugin Name: Digital Garden
 * Description: A plugin to create a digital garden with notes and tags.
 * Version: 1.2.0
 * Author: wolfpaw
 * Text Domain: digital-garden
 *
 * @package DigitalGarden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define plugin version and path.
define( 'DIGITAL_GARDEN_VERSION', '1.2.0' );
define( 'DIGITAL_GARDEN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'DIGITAL_GARDEN_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Include the necessary files.
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-cpt.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-taxonomy.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-meta.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-metabox.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-hashtags.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-frontend.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-bidirectional-linking.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-blocks.php';
require_once DIGITAL_GARDEN_PLUGIN_PATH . 'includes/class-digital-garden-notes-list-table.php';

add_action(
	'plugins_loaded',
	function () {
		new \DigitalGarden\Digital_Garden_Blocks();
	}
);

// Include the helper functions.
$helpers = glob( DIGITAL_GARDEN_PLUGIN_PATH . 'includes/helpers/*.php' );
foreach ( $helpers as $helper ) {
	require_once $helper;
}

// Include the render callbacks.
$render_callbacks = glob( DIGITAL_GARDEN_PLUGIN_PATH . 'includes/render-callbacks/*.php' );
foreach ( $render_callbacks as $render_callback ) {
	require_once $render_callback;
}

// Activation and deactivation hooks.
register_activation_hook( __FILE__, 'digital_garden_activate' );
register_deactivation_hook( __FILE__, 'digital_garden_deactivate' );

/**
 * Activation function.
 */
function digital_garden_activate() {
	// Register CPT and taxonomy first so their rewrite rules exist before flushing.
	Digital_Garden_CPT::register_post_type();
	Digital_Garden_Taxonomy::register_taxonomy();

	// Create the Digital Garden page.
	$page_id = get_option( 'digital_garden_page_id' );

	if ( ! $page_id || ! get_post( $page_id ) ) {
		$page_content = <<<'BLOCK_CONTENT'
<!-- wp:digital-garden/container -->
<div class="wp-block-digital-garden-container"><!-- wp:digital-garden/garden-title /-->

<!-- wp:digital-garden/tag-filter /-->

<!-- wp:group {"className":"digital-garden-archive-filters","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group digital-garden-archive-filters"><!-- wp:digital-garden/active-filter /-->

<!-- wp:digital-garden/completeness-filter /-->

<!-- wp:digital-garden/search /--></div>
<!-- /wp:group -->

<!-- wp:digital-garden/note-block -->
<div class="wp-block-digital-garden-note-block"><!-- wp:digital-garden/note-title -->
<h3 style="text-align:left" class="wp-block-digital-garden-note-title">Example Note Title</h3>
<!-- /wp:digital-garden/note-title -->

<!-- wp:digital-garden/note-content -->
<div style="text-align:left" class="wp-block-digital-garden-note-content">Note Content (full post content)</div>
<!-- /wp:digital-garden/note-content -->

<!-- wp:digital-garden/note-tags /-->

<!-- wp:digital-garden/note-completeness /-->

<!-- wp:digital-garden/note-featured-image /-->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:digital-garden/note-publish-date /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:digital-garden/note-modify-date /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:digital-garden/note-block --></div>
<!-- /wp:digital-garden/container -->
BLOCK_CONTENT;

		$page = array(
			'post_title'   => 'Digital Garden',
			'post_name'    => 'garden',
			'post_content' => $page_content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => 1,
		);

		$page_id = wp_insert_post( $page );
		update_option( 'digital_garden_page_id', $page_id );
	}

	// Flush rewrite rules after CPT and taxonomy are registered.
	flush_rewrite_rules();
}

/**
 * Deactivation function.
 */
function digital_garden_deactivate() {
	// Flush rewrite rules.
	flush_rewrite_rules();
}
