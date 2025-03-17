<?php
/**
 * Render callback for Search block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_search( $attributes, $content ) {
	return '<div class="digital-garden-search">[Search Placeholder]</div>';
}
