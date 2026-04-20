<?php
/**
 * Digital Garden Settings Class.
 *
 * @package DigitalGarden
 */

/**
 * This class handles the creation and management of the settings page for the Digital Garden plugin.
 */
class Digital_Garden_Settings {

	/**
	 * Initialize the class.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Add the settings page to the admin menu.
	 */
	public static function add_settings_page() {
		add_submenu_page(
			'edit.php?post_type=note',
			__( 'Digital Garden Settings', 'digital-garden' ),
			__( 'Settings', 'digital-garden' ),
			'manage_options',
			'digital-garden-settings',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	/**
	 * Register the settings and fields.
	 */
	public static function register_settings() {
		// Register the settings.
		register_setting( 'digital_garden_settings', 'digital_garden_display_last_edited' );
		register_setting( 'digital_garden_settings', 'digital_garden_display_first_created' );
		// Add the settings section.
		add_settings_section(
			'digital_garden_settings_section',
			__( 'Display Settings', 'digital-garden' ),
			null,
			'digital-garden-settings'
		);

		// Add the "Display Last Edited Timestamp" field.
		add_settings_field(
			'digital_garden_display_last_edited',
			__( 'Display Last Edited Timestamp', 'digital-garden' ),
			array( __CLASS__, 'display_last_edited_callback' ),
			'digital-garden-settings',
			'digital_garden_settings_section'
		);

		// Add the "Display First Created Timestamp" field.
		add_settings_field(
			'digital_garden_display_first_created',
			__( 'Display First Created Timestamp', 'digital-garden' ),
			array( __CLASS__, 'display_first_created_callback' ),
			'digital-garden-settings',
			'digital_garden_settings_section'
		);

	}

	/**
	 * Callback for the "Display Last Edited Timestamp" field.
	 */
	public static function display_last_edited_callback() {
		$option = get_option( 'digital_garden_display_last_edited' );
		echo '<input type="checkbox" name="digital_garden_display_last_edited" value="1"' . checked( 1, $option, false ) . '>';
	}

	/**
	 * Callback for the "Display First Created Timestamp" field.
	 */
	public static function display_first_created_callback() {
		$option = get_option( 'digital_garden_display_first_created' );
		echo '<input type="checkbox" name="digital_garden_display_first_created" value="1"' . checked( 1, $option, false ) . '>';
	}

	/**
	 * Render the settings page.
	 */
	public static function render_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Digital Garden Settings', 'digital-garden' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'digital_garden_settings' );
				do_settings_sections( 'digital-garden-settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}

// Initialize the class.
Digital_Garden_Settings::init();
