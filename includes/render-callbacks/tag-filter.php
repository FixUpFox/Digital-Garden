<?php
/**
 * Render callback for Tag Filter block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_tag_filter( $attributes, $content ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'note_tag',
			'hide_empty' => false,
		)
	);

	$output = '<fieldset class="digital-garden-tag-filter" data-filter-group="tags">';
	$output .= '<legend>' . esc_html__( 'Filter by tags', 'digital-garden' ) . '</legend>';

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		$output .= '<p class="digital-garden-filter__empty">' . esc_html__( 'No tags available yet.', 'digital-garden' ) . '</p>';
		$output .= '</fieldset>';
		return $output;
	}

	$output .= '<ul class="digital-garden-filter-list digital-garden-filter-list--tags">';

	foreach ( $terms as $term ) {
		$count      = isset( $term->count ) ? absint( $term->count ) : 0;
		$output .= '<li class="digital-garden-filter-list__item">';
		$output .= sprintf(
			'<label class="digital-garden-filter-button"><input type="checkbox" class="digital-garden-filter-input" data-filter-type="tag" data-filter-label="%1$s" value="%2$s" aria-label="%1$s" /> <span class="digital-garden-filter-button__label">%1$s</span> <span class="digital-garden-filter-count">(%3$d)</span></label>',
			esc_html( $term->name ),
			esc_attr( $term->slug ),
			$count
		);
		$output .= '</li>';
	}

	$output .= '</ul>';
	$output .= '</fieldset>';

	return $output;
}
