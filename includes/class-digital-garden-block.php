<?php
/**
 * Digital Garden Block Class
 *
 * This class handles the registration and rendering of the Digital Garden archive block.
 */

class Digital_Garden_Block {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_block' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend_scripts' ) );
		add_action( 'wp_ajax_digital_garden_fetch_note_excerpt', array( __CLASS__, 'digital_garden_fetch_note_excerpt' ) );
		add_action( 'wp_ajax_nopriv_digital_garden_fetch_note_excerpt', array( __CLASS__, 'digital_garden_fetch_note_excerpt' ) );
	}

	public static function register_block() {
		wp_register_script(
			'digital-garden-block',
			plugins_url( 'assets/js/digital-garden-block.js', __DIR__ ),
			array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data' ),
			DIGITAL_GARDEN_VERSION,
			true
		);

		wp_register_style(
			'digital-garden-block-editor-style',
			plugins_url( 'assets/css/digital-garden-block-editor.css', __DIR__ ),
			array( 'wp-edit-blocks' ),
			DIGITAL_GARDEN_VERSION
		);

		wp_register_style(
			'digital-garden-block-style',
			plugins_url( 'assets/css/digital-garden-block.css', __DIR__ ),
			array(),
			DIGITAL_GARDEN_VERSION
		);

		register_block_type(
			'digital-garden/archive',
			array(
				'editor_script'   => 'digital-garden-block',
				'editor_style'    => 'digital-garden-block-editor-style',
				'style'           => 'digital-garden-block-style',
				'render_callback' => array( __CLASS__, 'render_archive_block' ),
			)
		);
	}

	public static function enqueue_block_editor_assets() {
		wp_enqueue_script( 'digital-garden-block' );

		wp_localize_script(
			'digital-garden-block',
			'digitalGardenData',
			array(
				'tags' => self::get_note_tags(),
			)
		);
	}

	public static function enqueue_frontend_scripts() {
		if ( ( is_singular() && has_block( 'digital-garden/archive' ) ) || is_singular( 'note' ) ) {
			wp_enqueue_script(
				'digital-garden-frontend',
				plugins_url( 'assets/js/digital-garden-frontend.js', __DIR__ ),
				array( 'jquery' ),
				DIGITAL_GARDEN_VERSION,
				true
			);

			wp_localize_script(
				'digital-garden-frontend',
				'digitalGardenData',
				array(
					'tags'      => self::get_note_tags(),
					'nonce'     => wp_create_nonce( 'digital_garden_nonce' ),
					'ajax_url'  => admin_url( 'admin-ajax.php' ),
					'max_steps' => get_option( 'digital_garden_breadcrumb_steps', 5 ),
				)
			);

			wp_enqueue_style(
				'digital-garden-block-style',
				plugins_url( 'assets/css/digital-garden-block.css', __DIR__ ),
				array(),
				DIGITAL_GARDEN_VERSION
			);
		}
	}


	// Handle AJAX for note fetching
	public static function digital_garden_fetch_note_excerpt() {
		check_ajax_referer( 'digital_garden_nonce', 'nonce' );

		if ( isset( $_POST['note_id'] ) ) {
			$note_id = intval( $_POST['note_id'] );
			$note    = get_post( $note_id );

			if ( $note && 'note' === $note->post_type ) {
				$response = array(
					'title'   => get_the_title( $note ),
					'excerpt' => get_the_excerpt( $note ),
				);

				wp_send_json_success( array( 'content' => $response ) );
			}
		}

		wp_send_json_error( array( 'message' => 'Invalid note ID or note not found.' ) );
	}

	public static function get_note_tags() {
		$tags = get_terms(
			array(
				'taxonomy'   => 'note_tag',
				'hide_empty' => true,
			)
		);

		return $tags;
	}

	public static function render_archive_block( $attributes ) {
		$output = '<div class="digital-garden ' . ( isset( $attributes['className'] ) ? esc_attr( $attributes['className'] ) : '' ) . '">';

		// Query to fetch notes
		$args  = array(
			'post_type'      => 'note',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);
		$query = new WP_Query( $args );

		// Fetch note tags
		$tags = array();
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_tags = get_the_terms( get_the_ID(), 'note_tag' );
				if ( ! is_wp_error( $post_tags ) && ! empty( $post_tags ) ) {
					foreach ( $post_tags as $post_tag ) {
						if ( ! isset( $tags[ $post_tag->term_id ] ) ) {
							$tags[ $post_tag->term_id ] = array(
								'name'  => $post_tag->name,
								'count' => 0,
							);
						}
						++$tags[ $post_tag->term_id ]['count'];
					}
				}
			}
			wp_reset_postdata();
		}

		// Display tags as buttons
		if ( ! empty( $tags ) ) {
			$output .= '<div class="digital-garden-tag-buttons">';
			foreach ( $tags as $tag_id => $tag_info ) {
				$output .= '<button class="digital-garden-tag-button" data-tag-id="' . esc_attr( $tag_id ) . '">'
				. esc_html( $tag_info['name'] ) . ' (' . $tag_info['count'] . ')</button>';
			}
			$output .= '</div>';
		}

		// Display notes
		if ( $query->have_posts() ) {
			$output .= '<div class="digital-garden-items">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$permalink = get_permalink();
				$post_id   = get_the_ID();
				$post_tags = get_the_terms( get_the_ID(), 'note_tag' );

				// Get IDs of tags attached to notes for filtering
				$tag_ids = array();
				if ( ! is_wp_error( $post_tags ) && ! empty( $post_tags ) ) {
					$tag_ids = array_map(
						function ( $tag ) {
							return $tag->term_id;
						},
						$post_tags
					);
				}

				$output .= '<div class="digital-garden-note-item" data-post-id="' . esc_attr( $post_id ) . '" data-tag-ids="' . esc_attr( wp_json_encode( $tag_ids ) ) . '">';
				$output .= '<a href="' . esc_url( $permalink ) . '" class="digital-garden-note-link" data-note-id="' . esc_attr( $post_id ) . '">';
				$output .= '<h2>' . get_the_title() . '</h2>';
				$output .= '</a>';
				$output .= '</div>'; // .digital-garden-note-item
			}
			$output .= '</div>'; // .digital-garden-items
			wp_reset_postdata();
		}

		$output .= '</div>'; // .digital-garden
		return $output;
	}
}

Digital_Garden_Block::init();
