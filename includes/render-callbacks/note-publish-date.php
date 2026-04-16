<?php
/**
 * Render callback for Note Publish Date block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the note publish date block.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function render_note_publish_date( $attributes ) {
	$post_id     = isset( $attributes['postId'] ) ? (int) $attributes['postId'] : get_the_ID();
	$prefix      = isset( $attributes['prefix'] ) ? $attributes['prefix'] : 'Published';
	$site_date_format = get_option( 'date_format' );
	$date_format      = isset( $attributes['dateFormat'] ) && '' !== $attributes['dateFormat']
		? $attributes['dateFormat']
		: ( ! empty( $site_date_format ) ? $site_date_format : 'F j, Y' );

	$publish_date = get_the_date( $date_format, $post_id );

	// Initialize an empty string for styles.
	$styles = '';

	// Handle typography styles.
	if ( isset( $attributes['style']['typography'] ) ) {
		$typography = $attributes['style']['typography'];

		if ( isset( $typography['fontSize'] ) ) {
			$styles .= 'font-size:' . esc_attr( convert_to_css_var( $typography['fontSize'] ) ) . ';';
		}

		if ( isset( $typography['textAlign'] ) ) {
			$styles .= 'text-align:' . esc_attr( $typography['textAlign'] ) . ';';
		}
	}

	// Handle spacing styles.
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

	$label = '' !== $prefix ? esc_html( $prefix ) . '&#160;' : '';

	return sprintf(
		'<div class="digital-garden-note-publish-date" style="%1$s">%2$s%3$s</div>',
		esc_attr( $styles ),
		$label,
		esc_html( $publish_date )
	);
}
