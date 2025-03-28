<?php
/**
 * Render callback for Note Tags block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_tags() {
	// Get the current post ID
	$post_id = $block->context['postId'] ?? get_the_ID();

	// Get the tags for the post
	$tags = get_the_terms( $post_id, 'note_tag' );

	// Check if there are tags
	if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
		$tag_list = array_map(
			function ( $tag ) {
				return sprintf( '<span class="note-tag">%s</span>', esc_html( $tag->name ) );
			},
			$tags
		);

		$content = implode( ', ', $tag_list );
	} else {
		$content = 'No tags found.';
	}

	return sprintf(
		'<div class="digital-garden-note-tags">%s</div>',
		$content
	);
}
