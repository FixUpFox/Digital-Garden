<?php
/**
 * Render callback for Note Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_title( $attributes ) {
	$content = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
		? esc_html( $attributes['content'] )
		: 'Title';

	return sprintf(
		'<div class="digital-garden-note-title">%s</div>',
		$content
	);
}
