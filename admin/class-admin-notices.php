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
 * This class contain all the snippet or extra that improve the experience on the backend
 */
class Ca_Admin_Notices extends Ca_Admin_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		/*
		 * Load Wp_Admin_Notice for the notices in the backend
		 *
		 * First parameter the HTML, the second is the css class
		 */
		new WP_Admin_Notice( __( 'Updated Messages', CA_TEXTDOMAIN ), 'updated' );
		new WP_Admin_Notice( __( 'Error Messages', CA_TEXTDOMAIN ), 'error' );
		/*
		 * Dismissible notice
		 */
		dnh_register_notice( 'my_demo_notice', 'updated', __( 'This is my dismissible notice', CA_TEXTDOMAIN ) );
	}

}
