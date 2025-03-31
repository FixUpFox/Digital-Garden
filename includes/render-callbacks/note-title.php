<?php
/**
 * Render callback for Note Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_title( $attributes ) {
	$post_id = get_the_ID();
	$title   = $post_id ? get_the_title( $post_id ) : '[Missing Title]';

	// Initialize an empty string for styles
	$styles = '';

	// Handle text alignment
	if ( isset( $attributes['textAlign'] ) ) {
		$styles .= 'text-align:' . esc_attr( $attributes['textAlign'] ) . ';';
	}

	// Handle spacing styles
	if ( isset( $attributes['style']['spacing'] ) ) {
		$spacing = $attributes['style']['spacing'];

		if ( isset( $spacing['padding'] ) ) {
			foreach ( $spacing['padding'] as $side => $value ) {
				$styles .= 'padding-' . esc_attr( $side ) . ':' . esc_attr( convert_to_css_var( $value ) ) . ';';
			}
		}

		if ( isset( $spacing['margin'] ) ) {
			foreach ( $spacing['margin'] as $side => $value ) {
				$styles .= 'margin-' . esc_attr( $side ) . ':' . esc_attr( convert_to_css_var( $value ) ) . ';';
			}
		}
	}

	return sprintf(
		'<h3 class="digital-garden-note-title" style="%s">%s</h3>',
		$styles,
		esc_html( $title )
	);
}

add_action(
	'init',
	function () {
		register_block_type(
			__DIR__,
			array(
				'render_callback' => 'DigitalGarden\render_note_title',
			)
		);
	}
);
