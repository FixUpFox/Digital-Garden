<?php
/**
 * Render callback for Garden Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_garden_title( $attributes ) {
	$title = isset( $attributes['content'] ) ? esc_html( $attributes['content'] ) : 'Digital Garden';

	return sprintf(
		'<h2 class="digital-garden-title">%s</h2>',
		$title
	);
}
