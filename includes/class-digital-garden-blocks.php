<?php
namespace DigitalGarden;

defined( 'ABSPATH' ) || exit;

class Digital_Garden_Blocks {

	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action(
			'wp_enqueue_scripts',
			function () {
				if ( is_singular() && has_block( 'digital-garden/container' ) ) {
					wp_enqueue_style(
						'digital-garden-styles',
						DIGITAL_GARDEN_PLUGIN_URL . 'assets/css/digital-garden.css',
						array(),
						DIGITAL_GARDEN_VERSION
					);
				}
			}
		);
	}

	public function register_blocks() {
		$blocks = array(
			'container',
			'garden-title',
			'tag-filter',
			'completeness-filter',
			'active-filter',
			'search',
			'note-block',
			'note-title',
			'note-completeness',
			'note-tags',
			'note-featured-image',
			'note-publish-date',
			'note-modify-date',
		);

		foreach ( $blocks as $block ) {
			$block_dir       = "assets/js/blocks/{$block}";
			$block_path      = DIGITAL_GARDEN_PLUGIN_PATH . $block_dir;
			$script_handle   = "digital-garden-{$block}";
			$script_path     = "../{$block_dir}/index.js";
			$block_render    = strtr( $block, '-', '_' );
			$render_callback = "DigitalGarden\\render_{$block_render}";

			// Register the block script with dependencies
			wp_register_script(
				$script_handle,
				plugins_url( $script_path, __FILE__ ),
				array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
				DIGITAL_GARDEN_VERSION
			);

			// Register the block with block.json and attach the script
			register_block_type(
				$block_path,
				array(
					'editor_script'   => $script_handle,
					'render_callback' => $render_callback,
				)
			);
		}
	}
}
