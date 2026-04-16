<?php
/**
 * Render callback for Note Tags block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the note tags block.
 *
 * @return string
 */
function render_note_tags() {
	$post_id = get_the_ID();

	// Get the tags for the post.
	$tags = get_the_terms( $post_id, 'note_tag' );

	// Check if there are tags.
	if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
		$tag_list = array_map(
			function ( $tag ) {
				return sprintf( '<span class="note-tag">%s</span>', esc_html( $tag->name ) );
			},
			$tags
		);

		$content = implode( '', $tag_list );
	} else {
		$content = sprintf(
			'<span class="digital-garden-note-tags__empty">%s</span>',
			\esc_html__( 'No tags yet.', 'digital-garden' )
		);
	}

	return sprintf(
		'<div class="digital-garden-note-tags">%s</div>',
		$content
	);
}
