<?php
/**
 * Render callback for Digital Garden Container block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_container( $attributes, $content ) {
	return '<div class="digital-garden-container">' . do_blocks( $content ) . '</div>';
}
