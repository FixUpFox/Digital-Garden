<?php
/**
 * Render callback for Active Filter block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_active_filter( $attributes, $content ) {
	return '<div class="digital-garden-active-filter">[Active Filter Placeholder]</div>';
}
