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

/**
 * AJAX in the admin
 */
class Ca_Ajax_Admin extends Ca_Admin_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		if ( !apply_filters( 'csp_attendance_ca_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged user
		add_action( 'wp_ajax_your_admin_method', array( $this, 'your_admin_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @return void
	 */
	/*public function your_admin_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 2,
		);

		wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}*/

}

