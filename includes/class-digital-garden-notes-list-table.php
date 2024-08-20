<?php
/**
 * Digital Garden Notes List Table
 *
 * This class handles the addition of a column to the notes list table for the completness meta.
 */

class Digital_Garden_Notes_List_Table {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_filter( 'manage_note_posts_columns', array( __CLASS__, 'add_completneess_column' ) );
		add_action( 'manage_note_posts_custom_column', array( __CLASS__, 'render_completeness_column' ), 10, 2 );
//		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );
//		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Add the "Completeness" column to the notes list table.
	 *
	 * @param array $columns The existing columns.
	 * @return array The modified columns.
	 */
	public static function add_completneess_column( $columns ) {
		// Split the array at taxonomy-note_tag to insert our new column after it.
		$taxonomy_column = array_search( 'taxonomy-note_tag', array_keys( $columns ) );
		$columns = array_merge(

			array_slice( $columns, 1, $taxonomy_column ),
			['completeness' => __( 'Completeness', 'digital-garden' )],
			array_slice( $columns, $taxonomy_column )
		);

		return $columns;
	}

	/**
	 * Render the "Completeness" column in the notes list table.
	 */
	public static function render_completeness_column( $column, $post_id ) {
		$value = get_post_meta( $post_id, '_note_completeness', true );

		switch ( $value ) {
			case 'seedling':
				echo '<span style="color: #f1c40f;">&#x1F331;</span> Seedling';
				break;
			case 'sprout':
				echo '<span style="color: #2ecc71;">&#x1F331;</span> Sprout';
				break;
			case 'sapling':
				echo '<span style="color: #3498db;">&#x1F331;</span> Sapling';
				break;
			case 'evergreen':
				echo '<span style="color: #27ae60;">&#x1F332;</span> Evergreen';
				break;
		}
	}

}

// Initialize the class.
Digital_Garden_Notes_List_Table::init();
