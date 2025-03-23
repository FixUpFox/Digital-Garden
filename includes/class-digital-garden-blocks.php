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

		// Container Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/container';
		wp_register_script(
			'digital-garden-container',
			DIGITAL_GARDEN_PLUGIN_URL . 'assets/js/blocks/container/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-container',
				'render_callback' => '\\DigitalGarden\\render_container',
			)
		);

		// 1. Garden Title Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/garden-title';
		wp_register_script(
			'digital-garden-garden-title',
			DIGITAL_GARDEN_PLUGIN_URL . 'assets/js/blocks/garden-title/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
			DIGITAL_GARDEN_VERSION,
			true
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-garden-title',
				'render_callback' => '\\DigitalGarden\\render_garden_title',
			)
		);

		// 2. Tag Filter Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/tag-filter';
		wp_register_script(
			'digital-garden-tag-filter',
			plugins_url( '../assets/js/blocks/tag-filter/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-tag-filter',
				'render_callback' => 'DigitalGarden\\render_tag_filter',
			)
		);

		// 3. Completeness Filter Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/completeness-filter';
		wp_register_script(
			'digital-garden-completeness-filter',
			plugins_url( '../assets/js/blocks/completeness-filter/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-completeness-filter',
				'render_callback' => 'DigitalGarden\\render_completeness_filter',
			)
		);

		// 4. Active Filter Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/active-filter';
		wp_register_script(
			'digital-garden-active-filter',
			plugins_url( '../assets/js/blocks/active-filter/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-active-filter',
				'render_callback' => 'DigitalGarden\\render_active_filter',
			)
		);

		// 5. Search Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/search';
		wp_register_script(
			'digital-garden-search',
			plugins_url( '../assets/js/blocks/search/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-search',
				'render_callback' => 'DigitalGarden\\render_search',
			)
		);

		// 6. Note Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-block';
		wp_register_script(
			'digital-garden-note-block',
			plugins_url( '../assets/js/blocks/note-block/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-block',
				'render_callback' => 'DigitalGarden\\render_note_block',
			)
		);

		// 7. Note Title Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-title';
		wp_register_script(
			'digital-garden-note-title',
			plugins_url( '../assets/js/blocks/note-title/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-title',
				'render_callback' => 'DigitalGarden\\render_note_title',
			)
		);

		// 8. Note Completeness Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-completeness';
		wp_register_script(
			'digital-garden-note-completeness',
			plugins_url( '../assets/js/blocks/note-completeness/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-completeness',
				'render_callback' => 'DigitalGarden\\render_note_completeness',
			)
		);

		// 9. Note Tags Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-tags';
		wp_register_script(
			'digital-garden-note-tags',
			plugins_url( '../assets/js/blocks/note-tags/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-tags',
				'render_callback' => 'DigitalGarden\\render_note_tags',
			)
		);

		// 10. Note Featured Image Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-featured-image';
		wp_register_script(
			'digital-garden-note-featured-image',
			plugins_url( '../assets/js/blocks/note-featured-image/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-featured-image',
				'render_callback' => 'DigitalGarden\\render_note_featured_image',
			)
		);

		// 11. Note Publish Date Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-publish-date';
		wp_register_script(
			'digital-garden-note-publish-date',
			plugins_url( '../assets/js/blocks/note-publish-date/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-publish-date',
				'render_callback' => 'DigitalGarden\\render_note_publish_date',
			)
		);

		// 12. Note Modify Date Block
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-modify-date';
		wp_register_script(
			'digital-garden-note-modify-date',
			plugins_url( '../assets/js/blocks/note-modify-date/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-modify-date',
				'render_callback' => 'DigitalGarden\\render_note_modify_date',
			)
		);
	}
}
