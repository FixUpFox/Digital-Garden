<?php
/**
 * Render callback for Digital Garden Container block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the container block.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string
 */
function render_container( $attributes, $content ) {
	return '<div class="digital-garden-container">' . do_blocks( $content ) . '</div>';
}
