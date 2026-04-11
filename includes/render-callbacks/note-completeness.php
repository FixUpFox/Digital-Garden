<?php
/**
 * Render callback for Note Completeness block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_note_completeness() {
	$post_id = get_the_ID();

	// Get the completeness meta for the post
	$completeness = get_post_meta( $post_id, '_note_completeness', true );

	// Default message if no completeness is found
	if ( empty( $completeness ) ) {
		$completeness = __( 'Unknown completeness', 'digital-garden' );
}

	return sprintf(
		'<span class="digital-garden-note-completeness">%s</span>',
		esc_html( $completeness )
	);
}
