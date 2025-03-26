<?php
/**
 * Render callback for the Note Block.
 * This block dynamically renders each Note post using the layout defined inside the note-block.
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_block() {
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

	$output = '<div class="digital-garden-note-block">';

	// For each note post, render the inner layout blocks with post context
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$note_id = get_the_ID();

			$output .= '<div class="digital-garden-note">';
			$output .= render_inner_blocks_recursive( $note_block_layout, $note_id );
			$output .= '</div>';
		}
	}

	wp_reset_postdata();

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
