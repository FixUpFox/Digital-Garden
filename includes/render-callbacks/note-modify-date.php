<?php
/**
 * Render callback for Note Modify Date block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_modify_date( $attributes ) {
	$content = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
		? esc_html( $attributes['content'] )
		: 'Modify Date';

	return sprintf(
		'<div class="digital-garden-note-modify-date">%s</div>',
		$content
	);
}
