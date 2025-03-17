<?php
/**
 * Render callback for Note Featured Image block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_featured_image( $attributes, $content ) {
	return '<div class="digital-garden-note-featured-image">[Note Featured Image Placeholder]</div>';
}
