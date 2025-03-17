<?php
/**
 * Render callback for Note Completeness block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_completeness( $attributes, $content ) {
	return '<div class="digital-garden-note-completeness">[Note Completeness Placeholder]</div>';
}
