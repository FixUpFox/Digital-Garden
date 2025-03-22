<?php
/**
 * Render callback for Note Tags block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_tags( $attributes ) {
	$content = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
		? esc_html( $attributes['content'] )
		: 'Tags';

	return sprintf(
		'<div class="digital-garden-note-tags">%s</div>',
		$content
	);
}
