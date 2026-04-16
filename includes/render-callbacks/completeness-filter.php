<?php
/**
 * Render callback for Completeness Filter block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

use function Digital_Garden\completeness_list;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the completeness filter block.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string
 */
function render_completeness_filter( $attributes, $content ) {
	$options = completeness_list();

	$select_id = 'digital-garden-completeness-select-' . uniqid();

	$output = '<div class="digital-garden-completeness-filter" data-filter-group="completeness">';

	if ( empty( $options ) || ! is_array( $options ) ) {
		$output .= '<p class="digital-garden-filter__empty">' . esc_html__( 'No completeness options configured.', 'digital-garden' ) . '</p>';
		$output .= '</div>';
		return $output;
	}

	$output .= '<select id="' . esc_attr( $select_id ) . '" class="digital-garden-filter-select" data-filter-type="completeness" aria-label="' . esc_attr__( 'Filter notes by completeness', 'digital-garden' ) . '">';
	$output .= '<option value="">' . esc_html__( 'Completeness', 'digital-garden' ) . '</option>';

	foreach ( $options as $slug => $label ) {
		$output .= sprintf(
			'<option value="%1$s">%2$s</option>',
			esc_attr( $slug ),
			esc_html( $label )
		);
	}

	$output .= '</select>';
	$output .= '</div>';

	return $output;
}
