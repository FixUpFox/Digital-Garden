<?php
/**
 * Digital Garden Blocks Class.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

use function Digital_Garden\completeness_list;

defined( 'ABSPATH' ) || exit;

/**
 * Registers and manages all Digital Garden Gutenberg blocks.
 */
class Digital_Garden_Blocks {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action(
			'enqueue_block_editor_assets',
			function () {
				$screen = get_current_screen();
				if ( ! $screen || 'note' !== $screen->post_type ) {
					return;
				}
				wp_enqueue_script(
					'digital-garden-hashtag-autocomplete',
					DIGITAL_GARDEN_PLUGIN_URL . 'assets/js/hashtag-autocomplete.js',
					array( 'wp-hooks', 'wp-element', 'wp-api-fetch' ),
					DIGITAL_GARDEN_VERSION,
					true
				);
				wp_enqueue_script(
					'digital-garden-double-bracket-autocomplete',
					DIGITAL_GARDEN_PLUGIN_URL . 'assets/js/double-bracket-autocomplete.js',
					array( 'wp-hooks', 'wp-element', 'wp-api-fetch' ),
					DIGITAL_GARDEN_VERSION,
					true
				);
			}
		);
		wp_register_script(
			'digital-garden-breadcrumbs',
			DIGITAL_GARDEN_PLUGIN_URL . 'assets/js/digital-garden-breadcrumbs.js',
			array(),
			DIGITAL_GARDEN_VERSION,
			true
		);

		add_action(
			'wp_enqueue_scripts',
			function () {
				if ( ( is_singular() && has_block( 'digital-garden/container' ) ) || is_singular( 'note' ) ) {
					wp_enqueue_style(
						'digital-garden-styles',
						DIGITAL_GARDEN_PLUGIN_URL . 'assets/css/digital-garden.css',
						array(),
						DIGITAL_GARDEN_VERSION
					);
					wp_enqueue_script( 'digital-garden-archive-frontend' );
					wp_enqueue_script( 'digital-garden-breadcrumbs' );
				}
			}
		);
	}

	/**
	 * Register all blocks.
	 */
	public function register_blocks() {

		// Container Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/container';
		wp_register_script(
			'digital-garden-archive-frontend',
			DIGITAL_GARDEN_PLUGIN_URL . 'assets/js/digital-garden-archive.js',
			array(),
			DIGITAL_GARDEN_VERSION,
			true
		);
		wp_register_style(
			'digital-garden-block-editor',
			DIGITAL_GARDEN_PLUGIN_URL . 'assets/css/digital-garden-block-editor.css',
			array(),
			DIGITAL_GARDEN_VERSION
		);
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

		// Garden Title Block.
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

		// Tag Filter Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/tag-filter';
		wp_register_script(
			'digital-garden-tag-filter',
			plugins_url( '../assets/js/blocks/tag-filter/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-data', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-tag-filter',
				'editor_style'    => 'digital-garden-block-editor',
				'render_callback' => 'DigitalGarden\\render_tag_filter',
			)
		);

		// Completeness Filter Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/completeness-filter';
		wp_register_script(
			'digital-garden-completeness-filter',
			plugins_url( '../assets/js/blocks/completeness-filter/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		$options = array();

		foreach ( completeness_list() as $slug => $label ) {
			$options[] = array(
				'value' => $slug,
				'label' => $label,
			);
		}

		wp_localize_script(
			'digital-garden-completeness-filter',
			'digitalGardenCompleteness',
			array(
				'options'   => $options,
				'allLabel'  => \__( 'Completeness', 'digital-garden' ),
				'ariaLabel' => \__( 'Filter notes by completeness', 'digital-garden' ),
			)
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-completeness-filter',
				'editor_style'    => 'digital-garden-block-editor',
				'render_callback' => 'DigitalGarden\\render_completeness_filter',
			)
		);

		// Active Filter Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/active-filter';
		wp_register_script(
			'digital-garden-active-filter',
			plugins_url( '../assets/js/blocks/active-filter/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-active-filter',
				'editor_style'    => 'digital-garden-block-editor',
				'render_callback' => 'DigitalGarden\\render_active_filter',
			)
		);

		// Search Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/search';
		wp_register_script(
			'digital-garden-search',
			plugins_url( '../assets/js/blocks/search/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-search',
				'editor_style'    => 'digital-garden-block-editor',
				'render_callback' => 'DigitalGarden\\render_search',
			)
		);

		// Note Block.
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

		// Note Title Block.
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

		// Note Content Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-content';
		wp_register_script(
			'digital-garden-note-content',
			plugins_url( '../assets/js/blocks/note-content/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-content',
				'render_callback' => 'DigitalGarden\\render_note_content',
			)
		);

		// Note Completeness Block.
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

		// Note Tags Block.
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

		// Note Featured Image Block.
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

		// Note Publish Date Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-publish-date';
		wp_register_script(
			'digital-garden-note-publish-date',
			plugins_url( '../assets/js/blocks/note-publish-date/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-date' ),
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

		// Note Modify Date Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-modify-date';
		wp_register_script(
			'digital-garden-note-modify-date',
			plugins_url( '../assets/js/blocks/note-modify-date/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-date' ),
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

		// Note Breadcrumbs Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/note-breadcrumbs';
		wp_register_script(
			'digital-garden-note-breadcrumbs',
			plugins_url( '../assets/js/blocks/note-breadcrumbs/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-note-breadcrumbs',
				'render_callback' => 'DigitalGarden\\render_note_breadcrumbs',
			)
		);

		// Linked From Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/linked-from';
		wp_register_script(
			'digital-garden-linked-from',
			plugins_url( '../assets/js/blocks/linked-from/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-linked-from',
				'render_callback' => 'DigitalGarden\\render_linked_from',
			)
		);

		// Related Notes Block.
		$block_path = DIGITAL_GARDEN_PLUGIN_PATH . 'assets/js/blocks/related-notes';
		wp_register_script(
			'digital-garden-related-notes',
			plugins_url( '../assets/js/blocks/related-notes/index.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
			DIGITAL_GARDEN_VERSION,
			false
		);
		register_block_type(
			$block_path,
			array(
				'editor_script'   => 'digital-garden-related-notes',
				'render_callback' => 'DigitalGarden\\render_related_notes',
			)
		);

		// Single Note template.
		// The namespace before '//' becomes $template->plugin in the registry.
		register_block_template(
			'digital-garden//digital-garden-single-note',
			array(
				'title'       => __( 'Single item: Digital Garden Note', 'digital-garden' ),
				'description' => __( 'Displays a single note with breadcrumbs, linked-from, and related notes.', 'digital-garden' ),
				'post_types'  => array( 'note' ),
				'content'     => (string) file_get_contents( DIGITAL_GARDEN_PLUGIN_PATH . 'templates/single-note.html' ),
			)
		);
	}
}
