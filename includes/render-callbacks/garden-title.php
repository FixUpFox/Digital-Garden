<?php
/**
 * Render callback for Garden Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_garden_title( $attributes ) {
	$allowed_tags = array(
		'strong' => array(),
		'em'     => array(),
		'b'      => array(),
		'i'      => array(),
		'span'   => array( 'class' => array(), 'style' => array() ),
		'a'      => array( 'href' => array(), 'title' => array(), 'target' => array() ),
	);
	$title = isset( $attributes['content'] ) ? wp_kses( $attributes['content'], $allowed_tags ) : 'Digital Garden';
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
