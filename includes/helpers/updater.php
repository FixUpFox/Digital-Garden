<?php
/**
 * Plugin updater handler function.
 * Pings the Github repo that hosts the plugin to check for updates.
 *
 * Props Jack Whitworth https://jackwhitworth.com/blog/hosting-updateable-wordpress-plugins-on-github/
 */
function digital_garden_check_for_plugin_update( $transient ) {
	// If no update transient or transient is empty, return.
	if ( empty( $transient->checked ) ) {
		return $transient;
	}

	// Plugin slug, path to the main plugin file, and the URL of the update server
	$plugin_slug = 'digital-garden/digital-garden.php';
	$update_url  = 'https://raw.githubusercontent.com/FixUpFox/Digital-Garden/refs/heads/main/update-info.json';

	// Fetch update information from your server
	$response = wp_remote_get( $update_url );
	if ( is_wp_error( $response ) ) {
		return $transient;
	}

	// Parse the JSON response (update_info.json must return the latest version details)
	$update_info = json_decode( wp_remote_retrieve_body( $response ) );

	// If a new version is available, modify the transient to reflect the update
	if ( version_compare( $transient->checked[ $plugin_slug ], $update_info->new_version, '<' ) ) {
		$plugin_data                         = array(
			'slug'        => 'david-garden',
			'plugin'      => $plugin_slug,
			'new_version' => $update_info->new_version,
			'url'         => $update_info->url,
			'package'     => $update_info->package, // URL of the plugin zip file
		);
		$transient->response[ $plugin_slug ] = (object) $plugin_data;
	}

	return $transient;
}
add_filter( 'pre_set_site_transient_update_plugins', 'digital_garden_check_for_plugin_update' );
