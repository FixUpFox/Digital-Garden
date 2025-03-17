<?php
/**
 * Render callback for Note Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_title( $attributes, $content ) {
	return '<div class="digital-garden-note-title">[Note Title Placeholder]</div>';
}
