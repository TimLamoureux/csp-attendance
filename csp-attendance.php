<?php

/**
 *
 * @package   CSP_Attendance
 * @author	  Tim Lamoureux <tim@wcubemedia.com>
 * @copyright 2019 wCube Media
 * @license   GPL 2.0+
 * @link	  https://wcubemedia.com
 *
 * Plugin Name:	    CSP Attendance
 * Plugin URI:		@TODO
 * Description:	    This plugin allows to manage patrollers' attendance to various CSP events
 * Version:		    1.0.0
 * Author:			Tim Lamoureux
 * Author URI:		https://wcubemedia.com
 * Text Domain:	    csp-attendance
 * License:		    GPL 2.0+
 * License URI:	    http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:	    /languages
 * Requires PHP:	5.6
 * WordPress-Plugin-Boilerplate-Powered: v3.0.3
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

define( 'CA_VERSION', '1.0.0' );
define( 'CA_TEXTDOMAIN', 'csp-attendance' );
define( 'CA_NAME', 'CSP Attendance' );
define( 'CA_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'CA_PLUGIN_ABSOLUTE', __FILE__ );
define( 'CA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'CA_ATTENDANCE_CPT', 'wcm-attendance' );
define( 'CA_TIMEZONE', 'America/Whitehorse' ); // TODO: Make this an option and move in the init section
define( 'CA_REPORT_PAGE', 'Reports' ); // TODO: Am I still used?

/**
 * Load the textdomain of the plugin
 *
 * @return void
 */
function ca_load_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), CA_TEXTDOMAIN );
	load_textdomain( CA_TEXTDOMAIN, trailingslashit( WP_PLUGIN_DIR ) . CA_TEXTDOMAIN . '/languages/' . CA_TEXTDOMAIN . '-' . $locale . '.mo' );
}

add_action( 'plugins_loaded', 'ca_load_plugin_textdomain', 1 );
if ( version_compare( PHP_VERSION, '5.6.0', '<' ) ) {
	function ca_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	function ca_show_deactivation_notice() {
		echo wp_kses_post(
			sprintf(
				'<div class="notice notice-error"><p>%s</p></div>',
				__( '"Plugin Name" requires PHP 5.6 or newer.', CA_TEXTDOMAIN )
			)
		);
	}

	add_action( 'admin_init', 'ca_deactivate' );
	add_action( 'admin_notices', 'ca_show_deactivation_notice' );

	// Return early to prevent loading the other includes.
	return;
}

require_once( CA_PLUGIN_ROOT . 'vendor/autoload.php' );

require_once( CA_PLUGIN_ROOT . 'internals/functions.php' );
require_once( CA_PLUGIN_ROOT . 'internals/debug.php' );

/**
 * Create a helper function for easy SDK access.
 *
 * @global type $ca_fs
 * @return object
 */
function ca_fs() {
	global $ca_fs;

	if ( !isset( $ca_fs ) ) {
		require_once( CA_PLUGIN_ROOT . 'vendor/freemius/wordpress-sdk/start.php' );
		$ca_fs = fs_dynamic_init(
			array(
				'id'			 => '',
				'slug'		     => 'csp-attendance',
				'public_key'	 => '',
				'is_live'		 => false,
				'is_premium'	 => false,
				'has_addons'	 => false,
				'has_paid_plans' => false,
				'menu'		   => array(
					'slug' => 'csp-attendance',
				),
			)
		);


		if ( $ca_fs->is_premium() ) {
				$ca_fs->add_filter( 'support_forum_url', 'gt_premium_support_forum_url' );

				function gt_premium_support_forum_url( $wp_org_support_forum_url ) {
					return 'http://your url';
				}
			}
	}

	return $ca_fs;
}

// Init Freemius.
// ca_fs();

if ( ! wp_installing() ) {
	add_action( 'plugins_loaded', array( 'Ca_Initialize', 'get_instance' ) );
}
