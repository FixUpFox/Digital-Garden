<?php
/**
 * Render callback for Note Breadcrumbs block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the note breadcrumbs block.
 *
 * Outputs an empty placeholder element. The frontend script
 * (digital-garden-breadcrumbs.js) reads the data attributes and fills in
 * the visitor's recently-viewed notes from localStorage.
 *
 * @param array $attributes Block attributes.
 * @return string Rendered HTML placeholder.
 */
function render_note_breadcrumbs( $attributes ) {
	if ( ! is_singular( 'note' ) ) {
		return '';
	}

	$max_steps = isset( $attributes['maxSteps'] ) ? (int) $attributes['maxSteps'] : 5;
	$heading   = isset( $attributes['heading'] ) && '' !== $attributes['heading']
		? $attributes['heading']
		: \__( 'Recently Viewed Notes', 'digital-garden' );

	return sprintf(
		'<nav class="digital-garden-breadcrumbs-placeholder" data-max-steps="%d" data-heading="%s"></nav>',
		esc_attr( $max_steps ),
		esc_attr( $heading )
	);
}
