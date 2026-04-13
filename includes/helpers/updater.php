<?php
/**
 * Plugin updater — checks the GitHub Releases API for new versions.
 *
 * When a new release is tagged on GitHub the attached zip is used as the
 * update package, so no separate update-info.json file is required.
 */

define( 'DIGITAL_GARDEN_GITHUB_REPO', 'FixUpFox/Digital-Garden' );
define( 'DIGITAL_GARDEN_UPDATE_CACHE_KEY', 'digital_garden_github_release' );
define( 'DIGITAL_GARDEN_UPDATE_CACHE_TTL', 12 * HOUR_IN_SECONDS );

/**
 * Fetches the latest release from GitHub, with a 12-hour transient cache.
 *
 * @return object|false Release object on success, false on failure.
 */
function digital_garden_get_github_release() {
	$cached = get_transient( DIGITAL_GARDEN_UPDATE_CACHE_KEY );
	if ( false !== $cached ) {
		return $cached;
	}

	$api_url  = 'https://api.github.com/repos/' . DIGITAL_GARDEN_GITHUB_REPO . '/releases/latest';
	$response = wp_remote_get(
		$api_url,
		array(
			'headers' => array(
				'Accept'     => 'application/vnd.github+json',
				'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' ),
			),
			'timeout' => 10,
		)
	);

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return false;
	}

	$release = json_decode( wp_remote_retrieve_body( $response ) );
	if ( empty( $release->tag_name ) ) {
		return false;
	}

	set_transient( DIGITAL_GARDEN_UPDATE_CACHE_KEY, $release, DIGITAL_GARDEN_UPDATE_CACHE_TTL );
	return $release;
}

/**
 * Returns the download URL for the zip asset attached to a release.
 *
 * @param object $release GitHub release object.
 * @return string Zip URL, or empty string if not found.
 */
function digital_garden_get_release_zip_url( $release ) {
	if ( empty( $release->assets ) ) {
		return '';
	}
	foreach ( $release->assets as $asset ) {
		if ( '.zip' === substr( $asset->name, -4 ) ) {
			return $asset->browser_download_url;
		}
	}
	return '';
}

/**
 * Hooks into the WP plugin update transient to inject available update info.
 *
 * @param object $transient The update_plugins transient.
 * @return object
 */
function digital_garden_check_for_plugin_update( $transient ) {
	if ( empty( $transient->checked ) ) {
		return $transient;
	}

	$plugin_slug = 'digital-garden/digital-garden.php';
	$release     = digital_garden_get_github_release();

	if ( ! $release ) {
		return $transient;
	}

	$new_version     = ltrim( $release->tag_name, 'v' );
	$installed       = isset( $transient->checked[ $plugin_slug ] ) ? $transient->checked[ $plugin_slug ] : '0';
	$update_available = version_compare( $installed, $new_version, '<' );

	if ( ! $update_available ) {
		return $transient;
	}

	$zip_url = digital_garden_get_release_zip_url( $release );
	if ( empty( $zip_url ) ) {
		return $transient;
	}

	$transient->response[ $plugin_slug ] = (object) array(
		'slug'        => 'digital-garden',
		'plugin'      => $plugin_slug,
		'new_version' => $new_version,
		'url'         => $release->html_url,
		'package'     => $zip_url,
		'icons'       => array(),
		'banners'     => array(),
		'banners_rtl' => array(),
	);

	return $transient;
}
add_filter( 'pre_set_site_transient_update_plugins', 'digital_garden_check_for_plugin_update' );

/**
 * Provides plugin details for the "View version X details" modal in WP admin.
 *
 * @param false|object|array $result The result object or array.
 * @param string             $action The API action.
 * @param object             $args   Request arguments.
 * @return false|object
 */
function digital_garden_plugin_info( $result, $action, $args ) {
	if ( 'plugin_information' !== $action ) {
		return $result;
	}
	if ( empty( $args->slug ) || 'digital-garden' !== $args->slug ) {
		return $result;
	}

	$release = digital_garden_get_github_release();
	if ( ! $release ) {
		return $result;
	}

	$new_version = ltrim( $release->tag_name, 'v' );
	$zip_url     = digital_garden_get_release_zip_url( $release );

	return (object) array(
		'name'          => 'Digital Garden',
		'slug'          => 'digital-garden',
		'version'       => $new_version,
		'author'        => '<a href="https://david.garden">wolfpaw</a>',
		'homepage'      => 'https://github.com/' . DIGITAL_GARDEN_GITHUB_REPO,
		'download_link' => $zip_url,
		'requires'      => '5.0',
		'tested'        => '6.6.2',
		'requires_php'  => '7.0',
		'last_updated'  => isset( $release->published_at ) ? $release->published_at : '',
		'sections'      => array(
			'changelog' => isset( $release->body ) ? nl2br( esc_html( $release->body ) ) : '',
		),
	);
}
add_filter( 'plugins_api', 'digital_garden_plugin_info', 20, 3 );

/**
 * Clears the cached release data after a successful plugin update so the
 * next check always fetches fresh data from GitHub.
 *
 * @param WP_Upgrader $upgrader Upgrader instance.
 * @param array       $hook_extra Extra data about the upgrade.
 */
function digital_garden_clear_update_cache( $upgrader, $hook_extra ) {
	if (
		isset( $hook_extra['type'], $hook_extra['plugins'] ) &&
		'plugin' === $hook_extra['type'] &&
		in_array( 'digital-garden/digital-garden.php', $hook_extra['plugins'], true )
	) {
		delete_transient( DIGITAL_GARDEN_UPDATE_CACHE_KEY );
	}
}
add_action( 'upgrader_process_complete', 'digital_garden_clear_update_cache', 10, 2 );
