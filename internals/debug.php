<?php

/**
 * Plugin_name
 *
 * @package   Plugin_name
 * @author    Tim Lamoureux <tim@wcubemedia.com>
 * @copyright 2019 wCube Media
 * @license   GPL 2.0+
 * @link      https://wcubemedia.com
 */

$ca_debug = new WPBP_Debug( __( 'Plugin Name', CA_TEXTDOMAIN ) );

function ca_log( $text ) {
	global $ca_debug;
	$ca_debug->log( $text );
}

