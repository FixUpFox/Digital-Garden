<?php
/**
 * Render callback for Note Publish Date block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_publish_date( $attributes ) {
	$content = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
		? esc_html( $attributes['content'] )
		: 'Publish Date';

	return sprintf(
		'<div class="digital-garden-note-publish-date">%s</div>',
		$content
	);
}
