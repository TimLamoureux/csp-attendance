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
