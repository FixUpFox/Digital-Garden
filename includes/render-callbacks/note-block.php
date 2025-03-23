<?php
/**
 * Render callback for Note Block block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_block( $attributes, $content ) {
	$args = array(
		'post_type'      => 'note',
		'posts_per_page' => -1,
	);

	$query = new \WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return '<div class="digital-garden-note-block">No notes found.</div>';
	}

	$output = '<div class="digital-garden-note-block">';

	while ( $query->have_posts() ) {
		$query->the_post();

		$note_content = get_the_content();

		$output .= '<div class="digital-garden-note">';
		$output .= $note_content;
		$output .= '</div>';
	}

	\wp_reset_postdata();

	$output .= '</div>';

	return $output;
}
