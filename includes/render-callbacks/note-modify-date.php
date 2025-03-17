<?php
/**
 * Render callback for Note Modify Date block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_modify_date( $attributes, $content ) {
	return '<div class="digital-garden-note-modify-date">[Note Modify Date Placeholder]</div>';
}
