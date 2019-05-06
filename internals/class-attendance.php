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


class Ca_Attendance extends Ca_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		parent::initialize();

		//add_action( 'output_attendance_manager', array( $this, 'output_attendance_manager' ) );
	}

	/**
	 * Returns all the Events Manager events based on passed Args
	 *
	 * @param array $args Arguments to fetch events
	 *
	 * @return EM_Event|null
	 */
	public function get_events( $args = array() ) {

		// TODO: Implement Transient caching

		$defaults = array(
			'event_status' => 1,
			/*'scope' => 'past-month',*/
			'scope' => 'past',
			'orderby' => 'event_start_date, event_name',
			'order' => 'DESC',
			'limit' => 50,
		);

		$args = array_merge( $defaults, $args );

		if ( class_exists( 'EM_Events' ) ) {
			return EM_Events::get( $args );
		}

		return null;
	}
/*
	public function output_attendance_manager() {
		echo "ATTENDANCE MANAGER";

		include_once CA_PLUGIN_ROOT . 'public/partials/form-add-attendance.php';
		include_once CA_PLUGIN_ROOT . 'public/partials/table-attendance.php';

	}*/
}
