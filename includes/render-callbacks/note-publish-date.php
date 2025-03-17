<?php
/**
 * Render callback for Note Publish Date block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_publish_date( $attributes, $content ) {
	return '<div class="digital-garden-note-publish-date">[Note Publish Date Placeholder]</div>';
}
