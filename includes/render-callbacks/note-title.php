<?php
/**
 * Render callback for Note Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_title( $attributes ) {
	$title = get_the_title();

	$align     = isset( $attributes['textAlign'] ) ? esc_attr( $attributes['textAlign'] ) : 'left';
	$font_size = isset( $attributes['fontSize'] ) && 'large' === $attributes['fontSize'] ? '2rem' : '1rem';

	return sprintf(
		'<h3 style="text-align:%s; font-size:%s;">%s</h3>',
		$align,
		$font_size,
		esc_html( $title )
	);
}
