<?php
/**
 * Render callback for the Note Block.
 * This block dynamically renders each Note post using the layout defined inside the note-block.
 */

namespace DigitalGarden;

use function Digital_Garden\completeness_list;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_block( $attributes = array(), $content = '' ) {
	// Retrieve the full post content (including block markup) of the current page
	$block_content = get_the_content( '', '', get_the_ID() );

	// Parse the block markup into a structured array
	$parsed_blocks = parse_blocks( $block_content );
	$inner_layout  = array();

	$note_block_layout = array();

	// Traverse the parsed blocks to find the note-block inside the digital-garden/container
	foreach ( $parsed_blocks as $block ) {
		if (
			'digital-garden/container' === $block['blockName'] &&
			! empty( $block['innerBlocks'] )
		) {
			foreach ( $block['innerBlocks'] as $child_block ) {
				if ( 'digital-garden/note-block' === $child_block['blockName'] ) {
					$note_block_layout = $child_block['innerBlocks'];
					break 2; // Exit both loops once the layout is found
				}
			}
		}
	}

	// Query all published 'note' custom post type entries
	$query = new \WP_Query(
		array(
			'post_type'      => 'note',
			'posts_per_page' => -1,
		)
	);

	// Return early if no notes found
	if ( ! $query->have_posts() ) {
		return '<div class="digital-garden-note-block">No notes found.</div>';
	}

	// Initialize an empty string for styles
	$styles = '';

	// Handle border styles
	if ( isset( $attributes['style']['border'] ) ) {
		$border = $attributes['style']['border'];

		if ( isset( $border['color'] ) ) {
			$styles .= 'border-color:' . esc_attr( convert_to_css_var( $border['color'] ) ) . ';';
		}
		if ( isset( $border['style'] ) ) {
			$styles .= 'border-style:' . esc_attr( $border['style'] ) . ';';
		}
		if ( isset( $border['width'] ) ) {
			$styles .= 'border-width:' . esc_attr( $border['width'] ) . ';';
		}
		if ( isset( $border['radius'] ) ) {
			$styles .= 'border-radius:' . esc_attr( $border['radius'] ) . ';';
		}
	}

	// Handle box shadow
	if ( isset( $attributes['style']['boxShadow'] ) ) {
		$styles .= 'box-shadow:' . esc_attr( $attributes['style']['boxShadow'] ) . ';';
	}

	// Handle spacing styles
	if ( isset( $attributes['style']['spacing'] ) ) {
		$spacing = $attributes['style']['spacing'];

		if ( isset( $spacing['padding'] ) ) {
			foreach ( $spacing['padding'] as $side => $value ) {
				$styles .= 'padding-' . esc_attr( $side ) . ':' . esc_attr( convert_to_css_var( $value ) ) . ';';
			}
		}

		if ( isset( $spacing['margin'] ) ) {
			foreach ( $spacing['margin'] as $side => $value ) {
				$styles .= 'margin-' . esc_attr( $side ) . ':' . esc_attr( convert_to_css_var( $value ) ) . ';';
			}
		}
	}

	$default_completeness = array_key_first( completeness_list() );

	$output = '<div class="digital-garden-note-block" style="' . $styles . '">';

	// For each note post, render the inner layout blocks with post context
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$note_id = get_the_ID();

			$note_tags = get_the_terms( $note_id, 'note_tag' );
			$tag_slugs = array();

			if ( ! is_wp_error( $note_tags ) && ! empty( $note_tags ) ) {
				$tag_slugs = array_map(
					static function ( $tag ) {
						return sanitize_title( $tag->slug );
					},
					$note_tags
				);
			}

			$note_completeness = get_post_meta( $note_id, '_note_completeness', true );
			if ( empty( $note_completeness ) ) {
				$note_completeness = $default_completeness;
			}

			$published_timestamp = get_post_time( 'U', false, $note_id );
			$modified_timestamp  = get_post_modified_time( 'U', false, $note_id );

			$output .= sprintf(
				'<div class="digital-garden-note" data-note-id="%1$d" data-tags="%2$s" data-completeness="%3$s" data-title="%4$s" data-published="%5$s" data-modified="%6$s">',
				$note_id,
				esc_attr( wp_json_encode( array_values( $tag_slugs ) ) ),
				esc_attr( $note_completeness ),
				esc_attr( get_the_title( $note_id ) ),
				esc_attr( $published_timestamp ),
				esc_attr( $modified_timestamp )
			);
			$output .= render_inner_blocks_recursive( $note_block_layout, $note_id );
			$output .= '</div>';
		}
	}

	wp_reset_postdata();

	$output .= '<p class="digital-garden-note-block__empty" hidden>' . esc_html__( 'No notes match the current filters.', 'digital-garden' ) . '</p>';

	$output .= '</div>';

	return $output;
}

/**
 * Recursively render nested blocks using the saved layout and specific post data.
 */
function render_inner_blocks_recursive( $blocks, $post_id ) {
	$output = '';

	foreach ( $blocks as $block ) {
		$block_name = $block['blockName'] ?? '';
		$attrs      = $block['attrs'] ?? array();
		$inner      = '';

		if ( ! $block_name ) {
			continue;
		}

		// Handle any nested inner blocks
		if ( ! empty( $block['innerBlocks'] ) ) {
			$inner = render_inner_blocks_recursive( $block['innerBlocks'], $post_id );
		}

		$output .= render_dynamic_note_block( $block_name, $post_id, $attrs, $inner );

	}

	return $output;
}

/**
 * Dynamically dispatch the rendering of each supported note sub-block.
 */
function render_dynamic_note_block( $block_name, $post_id, $attrs = array(), $inner = '' ) {
	$attrs['postId'] = $post_id;

	switch ( $block_name ) {
		case 'digital-garden/note-title':
			return \DigitalGarden\render_note_title( $attrs );
		case 'digital-garden/note-content':
			return \DigitalGarden\render_note_content( $attrs );
		case 'digital-garden/note-tags':
			return \DigitalGarden\render_note_tags( $attrs );
		case 'digital-garden/note-completeness':
			return \DigitalGarden\render_note_completeness( $attrs );
		case 'digital-garden/note-featured-image':
			return \DigitalGarden\render_note_featured_image( $attrs );
		case 'digital-garden/note-publish-date':
			return \DigitalGarden\render_note_publish_date( $attrs );
		case 'digital-garden/note-modify-date':
			return \DigitalGarden\render_note_modify_date( $attrs );
		default:
			return $inner;
	}
}
