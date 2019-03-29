<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/TimLamoureux/csp-attendance
 * @since      1.0.0
 *
 * @package    CSP_Attendance
 * @subpackage CSP_Attendance/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CSP_Attendance
 * @subpackage CSP_Attendance/admin
 * @author     Tim Lamoureux <tim@wcubemedia.com>
 */
class CSP_Attendance_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function initialize( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}




	// TODO: Probably not useful anymore, copy pasted from csp-attendance-bck
	// The check is still relevant though. Needs to be moved where appropriate
	public function admin_notice_em_absent() {
		$class = 'notice notice-warning';
		$message = sprintf( esc_html__( 'Events Manager plugin must be active for %s to work.', 'csp-attendance' ), $this->plugin_name );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

}
