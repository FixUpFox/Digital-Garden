<?php
/**
 * Render callback for Note Block block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_block( $attributes, $content ) {
	return sprintf(
		'<div class="digital-garden-note-block">%s</div>',
		$content
	);
}
