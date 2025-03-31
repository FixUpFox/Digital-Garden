<?php
/**
 * Render callback for Note Content block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_content( $attributes ) {
	$post_id = $attributes['postId'] ?? null;
	$content = $post_id ? apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ) : '[Missing Content]';

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
		'<div class="digital-garden-note-content" style="%s">%s</div>',
		$styles,
		$content
	);
}
