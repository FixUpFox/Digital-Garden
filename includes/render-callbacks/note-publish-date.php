<?php
/**
 * Render callback for Note Publish Date block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_publish_date( $attributes ) {
	$post_id      = get_the_ID();
	$publish_date = get_the_date( '', $post_id );

	// Initialize an empty string for styles
	$styles = '';

	// Handle typography styles
	if ( isset( $attributes['style']['typography'] ) ) {
		$typography = $attributes['style']['typography'];

		if ( isset( $typography['fontSize'] ) ) {
			$styles .= 'font-size:' . esc_attr( convert_to_css_var( $typography['fontSize'] ) ) . ';';
		}
	}

	// Handle spacing styles
	if ( isset( $attributes['style']['spacing'] ) ) {
		$spacing = $attributes['style']['spacing'];

		if ( isset( $spacing['padding'] ) ) {
			$padding = $spacing['padding'];
			foreach ( $padding as $side => $value ) {
				$styles .= 'padding-' . esc_attr( $side ) . ':' . esc_attr( convert_to_css_var( $value ) ) . ';';
			}
		}

		if ( isset( $spacing['margin'] ) ) {
			$margin = $spacing['margin'];
			foreach ( $margin as $side => $value ) {
				$styles .= 'margin-' . esc_attr( $side ) . ':' . esc_attr( convert_to_css_var( $value ) ) . ';';
			}
		}
	}

	return sprintf(
		'<div class="digital-garden-note-publish-date" style="%s">%s</div>',
		$styles,
		esc_html( $publish_date )
	);
}
