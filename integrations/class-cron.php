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
 * This class contain the Widget stuff
 */
class Ca_Cron extends Ca_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		/*
		 * Load CronPlus
		 */
		$args = array(
			'recurrence'       => 'hourly',
			'schedule'         => 'schedule',
			'name'             => 'cronplusexample',
			'cb'               => array( $this, 'cronplus_example' ),
			'plugin_root_file' => 'csp-attendance.php',
		);

		$cronplus = new CronPlus( $args );
        // Schedule the event
		$cronplus->schedule_event();
        // Remove the event by the schedule
        $cronplus->clear_schedule_by_hook();
        // Jump the scheduled event
        $cronplus->unschedule_specific_event();
	}

	/**
	 * Cron example
	 *
	 * @param integer $id The ID.
	 *
	 * @return void
	 */
	public function cronplus_example( $id ) {
		echo esc_html( $id );
	}

}

