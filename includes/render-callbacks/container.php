<?php
/**
 * Render callback for Digital Garden Container block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_container( $attributes, $content ) {
	return sprintf(
		'<div class="digital-garden-container">%s</div>',
		$content
	);
}
