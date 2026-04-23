<?php
/**
 * Render callback for Related Notes block.
 *
 * @package DigitalGarden
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render callback for the related notes block.
 *
 * Scores candidate notes from three sources:
 *   - Shared note_tag terms  (+1 per shared tag)
 *   - Backlinks stored in _linked_from meta (+1)
 *   - Forward [[wikilinks]] and href links in this note's content (+1)
 *
 * @param array $attributes Block attributes.
 * @return string Rendered HTML, or empty string when no related notes exist.
 */
function render_related_notes( $attributes ) {
	$post_id   = get_the_ID();
	$max_items = isset( $attributes['maxItems'] ) ? (int) $attributes['maxItems'] : 5;

	if ( ! $post_id ) {
		return '';
	}

	$scores = array(); // note_id (int) => relevance score (int)

	// --- Tag-based relationships ---
	$tags = get_the_terms( $post_id, 'note_tag' );
	if ( $tags && ! is_wp_error( $tags ) ) {
		$tag_ids = wp_list_pluck( $tags, 'term_id' );

		$tag_query = new \WP_Query(
			array(
				'post_type'      => 'note',
				'post_status'    => 'publish',
				'posts_per_page' => 50,
				'post__not_in'   => array( $post_id ),
				'fields'         => 'ids',
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'taxonomy' => 'note_tag',
						'field'    => 'term_id',
						'terms'    => $tag_ids,
					),
				),
			)
		);

		foreach ( $tag_query->posts as $note_id ) {
			$note_tags    = get_the_terms( $note_id, 'note_tag' );
			$note_tag_ids = ( $note_tags && ! is_wp_error( $note_tags ) )
				? wp_list_pluck( $note_tags, 'term_id' )
				: array();
			$shared       = count( array_intersect( $tag_ids, $note_tag_ids ) );

			$scores[ $note_id ] = ( $scores[ $note_id ] ?? 0 ) + $shared;
		}
	}

	// --- Backlink relationships (notes that link TO this note) ---
	$backlinks = get_post_meta( $post_id, '_linked_from', false );
	foreach ( array_unique( (array) $backlinks ) as $linked_id ) {
		$linked_id = (int) $linked_id;
		if ( $linked_id !== $post_id && 'publish' === get_post_status( $linked_id ) ) {
			$scores[ $linked_id ] = ( $scores[ $linked_id ] ?? 0 ) + 1;
		}
	}

	// --- Forward link relationships (notes this note links TO) ---
	$content = get_post_field( 'post_content', $post_id );

	// [[wikilink]] syntax.
	if ( preg_match_all( '/\[\[([^\]]+)\]\]/', $content, $wikilink_matches ) ) {
		foreach ( $wikilink_matches[1] as $title ) {
			$slug       = sanitize_title( strtolower( $title ) );
			$linked     = get_page_by_path( $slug, OBJECT, 'note' );
			if ( $linked && $linked->ID !== $post_id && 'publish' === get_post_status( $linked->ID ) ) {
				$scores[ $linked->ID ] = ( $scores[ $linked->ID ] ?? 0 ) + 1;
			}
		}
	}

	// Regular href links to other notes.
	if ( preg_match_all( '/href="([^"]+)"/', $content, $href_matches ) ) {
		foreach ( $href_matches[1] as $url ) {
			$linked_id = url_to_postid( $url );
			if ( $linked_id && (int) $linked_id !== $post_id && get_post_type( $linked_id ) === 'note' && 'publish' === get_post_status( $linked_id ) ) {
				$scores[ $linked_id ] = ( $scores[ $linked_id ] ?? 0 ) + 1;
			}
		}
	}

	if ( empty( $scores ) ) {
		return '';
	}

	arsort( $scores );
	$top_ids = array_slice( array_keys( $scores ), 0, $max_items );

	$items = '';
	foreach ( $top_ids as $note_id ) {
		$items .= sprintf(
			'<li class="digital-garden-related-notes__item"><a class="digital-garden-related-notes__link" href="%s">%s</a></li>',
			esc_url( get_permalink( $note_id ) ),
			esc_html( get_the_title( $note_id ) )
		);
	}

	return sprintf(
		'<section class="digital-garden-related-notes"><ul class="digital-garden-related-notes__list">%s</ul></section>',
		$items
	);
}
