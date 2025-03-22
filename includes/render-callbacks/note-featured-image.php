<?php
/**
 * Render callback for Note Featured Image block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_featured_image( $attributes ) {
	$content = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
		? esc_html( $attributes['content'] )
		: 'Featured Image';

	return sprintf(
		'<div class="digital-garden-note-featured-image">%s</div>',
		$content
	);
}
