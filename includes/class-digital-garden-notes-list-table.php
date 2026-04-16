<?php
/**
 * Digital Garden Notes List Table.
 *
 * @package DigitalGarden
 */

use function Digital_Garden\completeness_list;

/**
 * This class handles the addition of a column to the notes list table for the completeness meta.
 */
class Digital_Garden_Notes_List_Table {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_filter( 'manage_note_posts_columns', array( __CLASS__, 'add_completneess_column' ) );
		add_action( 'manage_note_posts_custom_column', array( __CLASS__, 'render_completeness_column' ), 10, 2 );
		// add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) ); .
		// add_action( 'admin_init', array( __CLASS__, 'register_settings' ) ); .
	}

	/**
	 * Add the "Completeness" column to the notes list table.
	 *
	 * @param array $columns The existing columns.
	 * @return array The modified columns.
	 */
	public static function add_completneess_column( $columns ) {
		// Split the array at taxonomy-note_tag to insert our new column after it.
		$taxonomy_column = array_search( 'taxonomy-note_tag', array_keys( $columns ), true );
		$columns         = array_merge(
			array_slice( $columns, 1, $taxonomy_column ),
			array( 'completeness' => __( 'Completeness', 'digital-garden' ) ),
			array_slice( $columns, $taxonomy_column )
		);

		return $columns;
	}

	/**
	 * Render the "Completeness" column in the notes list table.
	 *
	 * @param string $column  The column name.
	 * @param int    $post_id The post ID.
	 */
	public static function render_completeness_column( $column, $post_id ) {
		$value = get_post_meta( $post_id, '_note_completeness', true );

		if ( array_key_exists( $value, completeness_list() ) ) {
			echo esc_html( completeness_list()[ $value ] );
		}
	}
}

// Initialize the class.
Digital_Garden_Notes_List_Table::init();
