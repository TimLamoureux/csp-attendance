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
 * This class contain the Enqueue stuff for the frontend
 */
class Ca_Enqueue extends Ca_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		parent::initialize();

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_js_vars' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_styles() {
		wp_enqueue_style( CA_TEXTDOMAIN . '-plugin-styles', plugins_url( 'assets/css/public.css', CA_PLUGIN_ABSOLUTE ), array(), CA_VERSION );

		// TODO: Only enqueue style flatpickr when needed. Same with script
		//wp_enqueue_style( 'flatpickr', 'https://unpkg.com/flatpickr/dist/flatpickr.min.css' );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_scripts() {
		//wp_enqueue_script( CA_TEXTDOMAIN . '-plugin-script', plugins_url( 'assets/js/public.js', CA_PLUGIN_ABSOLUTE ), array( 'jquery' ), CA_VERSION );


	}

	/**
	 * Print the PHP var in the HTML of the frontend for access by JavaScript
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_js_vars() {
		/*wp_localize_script(
             CA_TEXTDOMAIN . '-plugin-script', 'ca_js_vars', array(
			'alert' => __( 'Hey! You have clicked the button!', CA_TEXTDOMAIN ),
		)
		);*/
	}

}
