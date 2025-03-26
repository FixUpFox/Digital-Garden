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

	return '<div class="digital-garden-note-content">' . $content . '</div>';
}
