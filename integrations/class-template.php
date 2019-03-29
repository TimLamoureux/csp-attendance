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
 * This class contain the Templating stuff for the frontend
 */
class Ca_Template extends Ca_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
        parent::initialize();
		// Override the template hierarchy for load /templates/content-demo.php
		add_filter( 'template_include', array( __CLASS__, 'load_content_demo' ) );
		add_filter( 'template_include', array( __CLASS__, 'load_page_attendance_manage' ) );

	}

	/**
	 * Example for override the template system on the frontend
	 *
	 * @param string $original_template The original templace HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function load_content_demo( $original_template ) {
		if ( is_singular( 'demo' ) && in_the_loop() ) {
			return wpbp_get_template_part( CA_TEXTDOMAIN, 'content', 'demo', false );
		}

		return $original_template;
	}


	public static function load_page_attendance_manage( $original_template ) {
		/* TODO Optimize me to use the page template from the Admin area
		*	Issue is the page template is the full path
		*/
		if ( is_page( 'attendance' ) ) {

			// get_page_template_slug() returns the template path

			// TODO: Check if flatpickr already loaded before adding it again
			//wp_enqueue_script( 'flatpickr', 'https://unpkg.com/flatpickr', null, false, true );
			wp_enqueue_script( CA_TEXTDOMAIN . '-flatpickr', plugins_url('assets/lib/flatpickr/flatpickr.min.js', CA_PLUGIN_ABSOLUTE ), null, false, true );
			wp_enqueue_style( CA_TEXTDOMAIN . '-flatpickr', plugins_url('assets/lib/flatpickr/flatpickr.min.css', CA_PLUGIN_ABSOLUTE ), null, false );

			wp_enqueue_script( 'js.cookie', 'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js', null, false, true );
			//wp_enqueue_script( CA_TEXTDOMAIN . '-test', plugins_url('assets/js/test.js', CA_PLUGIN_ABSOLUTE ), 'jquery', CA_VERSION, true );
			wp_enqueue_script( CA_TEXTDOMAIN . '-attendance-manage', plugins_url('assets/js/csp-attendance-manage.js', CA_PLUGIN_ABSOLUTE ), array( 'jquery', 'jquery-ui-autocomplete', CA_TEXTDOMAIN . '-flatpickr' ), CA_VERSION, true );

			//wp_enqueue_script( CA_TEXTDOMAIN . '-plugin-script', plugins_url( 'public/assets/js/public.js', CA_PLUGIN_ABSOLUTE ), array( 'jquery' ), CA_VERSION );



			//return wpbp_get_template_part( CA_TEXTDOMAIN, 'page', 'attendance-manage', true );
		}

		return $original_template;
	}
}
