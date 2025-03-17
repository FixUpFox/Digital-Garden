<?php
/**
 * Render callback for Note Tags block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_tags( $attributes, $content ) {
	return '<div class="digital-garden-note-tags">[Note Tags Placeholder]</div>';
}
