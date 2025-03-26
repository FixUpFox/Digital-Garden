<?php
/**
 * Render callback for Note Title block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_title( $attributes ) {
	$post_id = $attributes['postId'] ?? null;
	$title   = $post_id ? get_the_title( $post_id ) : '[Missing Title]';

	return '<h3 class="digital-garden-note-title">' . esc_html( $title ) . '</h3>';
}
