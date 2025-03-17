<?php
/**
 * Render callback for Garden Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_garden_title( $attributes, $content ) {
	return '<div class="digital-garden-garden-title">[Garden Title Placeholder]</div>';
}
