<?php
/**
 * Render callback for Active Filter block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the active filter block.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string
 */
function render_active_filter( $attributes, $content ) {
	$recently_updated   = esc_html__( 'Recently updated', 'digital-garden' );
	$recently_published = esc_html__( 'Recently published', 'digital-garden' );

	$select_id = 'digital-garden-order-select-' . uniqid();

	$output  = '<div class="digital-garden-active-filter" data-filter-group="active">';
	$output .= '<select id="' . esc_attr( $select_id ) . '" class="digital-garden-filter-select digital-garden-active-filter__select" aria-label="' . esc_attr__( 'Order notes by', 'digital-garden' ) . '">';
	$output .= '<option value="published" selected="selected">' . $recently_published . '</option>';
	$output .= '<option value="modified">' . $recently_updated . '</option>';
	$output .= '</select>';
	$output .= '</div>';

	return $output;
}
