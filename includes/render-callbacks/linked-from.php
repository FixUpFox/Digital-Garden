<?php
/**
 * Render callback for Linked From block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the linked-from block.
 *
 * Reads the _linked_from post meta recorded by the bidirectional-linking
 * class and displays a list of published notes that link to the current note.
 *
 * @param array $attributes Block attributes.
 * @return string Rendered HTML, or empty string when no backlinks exist.
 */
function render_linked_from( $attributes ) {
	$post_id = get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$raw = get_post_meta( $post_id, '_linked_from', false );
	if ( empty( $raw ) ) {
		return '';
	}

	$items = '';
	foreach ( array_unique( (array) $raw ) as $linked_id ) {
		$linked_id = (int) $linked_id;
		if ( $linked_id === $post_id || 'publish' !== get_post_status( $linked_id ) ) {
			continue;
		}
		$items .= sprintf(
			'<li class="digital-garden-linked-from__item"><a class="digital-garden-linked-from__link" href="%s">%s</a></li>',
			esc_url( get_permalink( $linked_id ) ),
			esc_html( get_the_title( $linked_id ) )
		);
	}

	if ( '' === $items ) {
		return '';
	}

	return sprintf(
		'<section class="digital-garden-linked-from"><ul class="digital-garden-linked-from__list">%s</ul></section>',
		$items
	);
}
