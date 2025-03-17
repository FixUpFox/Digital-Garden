<?php
/**
 * Render callback for Tag Filter block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_tag_filter( $attributes, $content ) {
	return '<div class="digital-garden-tag-filter">[Tag Filter Placeholder]</div>';
}
