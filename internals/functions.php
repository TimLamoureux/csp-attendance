<?php

/**
 * CSP_Attendance
 *
 * @package   CSP_Attendance
 * @author    Tim Lamoureux <tim@wcubemedia.com>
 * @copyright 2019 wCube Media
 * @license   GPL 2.0+
 * @link      https://wcubemedia.com
 */

/**
 * Get the settings of the plugin in a filterable way
 *
 * @return array
 */
function ca_get_settings() {
	return apply_filters( 'ca_get_settings', get_option( CA_TEXTDOMAIN . '-settings' ) );
}

function locate_partial( $plugin_slug, $slug, $name = '', $include = true ) {
	// Based on wpbp_get_template_part

	$template = '';
	$plugin_slug = $plugin_slug . '/';
	$path = WP_PLUGIN_DIR . '/'. $plugin_slug . 'templates/';

	// Look in yourtheme/slug-name.php and yourtheme/plugin-name/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", $plugin_slug . "{$slug}-{$name}.php" ) );
		/*em_locate_template()*/
	} else {
		$template = locate_template( array( "{$slug}.php", $plugin_slug . "{$slug}.php" ) );
	}



	return apply_filters( 'ca_located_partial', $located );
}