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
	$align = isset( $attributes['textAlign'] ) ? esc_attr( $attributes['textAlign'] ) : 'left';
	$level = isset( $attributes['level'] ) ? intval( $attributes['level'] ) : 2;

	return sprintf(
		'<h%d class="digital-garden-title" style="text-align:%s;">%s</h%d>',
		$level,
		$align,
		$title,
		$level
	);
}

// function render_garden_title( $attributes ) {
//     $title = isset( $attributes['content'] ) && ! empty( $attributes['content'] )
//         ? esc_html( $attributes['content'] )
//         : 'Welcome to My Garden';

//     return sprintf(
//         '<h2 class="digital-garden-title">%s</h2>',
//         $title
//     );
// }
