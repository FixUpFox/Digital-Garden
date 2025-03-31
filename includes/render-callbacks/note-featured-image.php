<?php
/**
 * Render callback for Note Featured Image block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_featured_image() {
	$post_id = get_the_ID();

	// Get the featured image URL for the current post
	$image_url = get_the_post_thumbnail_url( $post_id, 'full' );

	// If there's no featured image, optionally handle this case
	if ( ! $image_url ) {
		return '<div class="digital-garden-note-featured-image">No Featured Image</div>';
	}

	return sprintf(
		'<div class="digital-garden-note-featured-image">
			<img src="%s" alt="%s" style="max-width:100%%;"/>
		</div>',
		esc_url( $image_url ),
		esc_attr( get_the_title( $post_id ) )
	);
}
