<?php
/**
 * Render callback for Note Completeness block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_completeness( $attributes ) {
	$content = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
		? esc_html( $attributes['content'] )
		: 'Completeness';

	return sprintf(
		'<div class="digital-garden-note-completeness">%s</div>',
		$content
	);
}
