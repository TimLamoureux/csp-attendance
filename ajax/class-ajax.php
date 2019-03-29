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
 * AJAX in the public
 */
class Ca_Ajax extends Ca_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
		/*
		 * TODO: Commented because it prevented ajax from happening. Investigate on what is this filter.
		 */
		/*if ( !apply_filters( 'csp_attendance_ca_ajax_initialize', true ) ) {
			return;
		}*/

		// For not logged user
		//add_action( 'wp_ajax_nopriv_your_method', array( $this, 'your_method' ) );


		if ( current_user_can( 'list_users') ) {
			add_action('wp_ajax_get_patrollers', array( $this, 'ajax_patrollers' ));
		}

		if ( current_user_can('pods_add_wcm-attendance') ) {
			add_action('wp_ajax_attendance_form_process', array( $this, 'attendance_form_process' ));
			add_action('wp_ajax_attendance_retrieve', array( $this, 'attendance_retrieve' ));
			add_action('wp_ajax_attendance_delete', array( $this, 'attendance_delete' ));
		}

	}

	/**
	 * The method to run on ajax
	 *
	 * @return void
	 */
	/*public function your_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 1,
		);

		wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}*/

	function ajax_patrollers() {
		global $wpdb; //get access to the WordPress database object variable

		//get names of all businesses
		$name = $wpdb->esc_like(stripslashes($_POST['patroller'])).'%'; //escape for use in LIKE statement
		$sql = "select ID, display_name 
		from $wpdb->users
		where display_name like %s";

		$sql = $wpdb->prepare($sql, $name);

		$results = $wpdb->get_results($sql);

		//copy the business titles to a simple array
		$patrollers = array();
		foreach( $results as $r )
			$patrollers[] = [
				"value" => $r->ID,
				"label" => addslashes($r->display_name)
			];

		echo json_encode($patrollers);

		die(); //stop "0" from being output
	}

	/**
	 * Processes submission of the attendance form, to track hours for each patrollers
	 */
	function attendance_form_process() {
		if (!current_user_can('pods_add_wcm-attendance'))
		{
			wp_send_json_error(__("You do not have sufficient permissions to manage attendance."), 403);
		}

		if ( !wp_verify_nonce( $_POST['attendance-form-nonce'], 'attendance-form' ) ) {
			wp_send_json_error(__("Nonce security could not be verified"), 403);
		}

		if ( isset( $_POST['submitted'] ) && isset( $_POST['attendance-form-nonce'] ) ) {

			// TODO: Add check for existence of attendance, load attendance table on event select, update table when attendance is added

			$params = array();
			parse_str($_POST['form_data'], $params);

			$errors = array();

			$patroller = get_user_by('id', $params['patroller-id']);
			if ( empty( $patroller ) )
				$errors[] = __("Could not find user", 'wcm');

			if ( !is_int(intval($params['event'])) )
				$errors[] = __("Supplied event id is not a number", 'wcm');
			else {
				$ev = em_get_event($params['event']);
				if ( null == $ev->event_id ) // An Event object is always returned even if event is not found. Checking ID to make sure
					$errors[] = __("Could not find event", 'wcm');
			}

			if ( empty($params['type'] ) ) {
				$errors[] = __("You must enter a patrolling type", 'wcm');
			}


			// TODO: Get full string for date/time to better compute time spent patrolling

			if ( !empty($errors) )
				wp_send_json_error($errors, 400);


			$attendance = array(
				'patroller_id' => $params['patroller-id'],
				'type' => $params['type'],
				'event_post_id' => $ev->post_id,
				'event_id' => $ev->event_id,
				'time_in' => $params['event-start-date'] . " " . $params['time-start'],
				'time_out' => $params['event-start-date'] . " " . $params['time-end'],
				'notes' => $params['notes'],
				'added_by' => get_current_user_id()

			);

			$pod = pods( 'wcm-attendance' );
			$attendance_id = $pod->add($attendance);



			$output['nonce'] = wp_create_nonce('attendance-form');
			$output['saved'] = $attendance;
			$output['saved']['id'] = $attendance_id;
			$output['saved']['patroller'] = $patroller->data->display_name;
			$output['saved']['can_delete'] = current_user_can( 'pods_delete_wcm-attendance' );

			$json = json_encode($output);

			echo $json;
		}

		wp_die();
	}

	/**
	 * AJAX call to retrieve the list of users attending a specific event
	 */
	function attendance_retrieve() {

		// TODO: Add capability check

		if ( !$_POST['event_id'] ) {
			wp_send_json_error("Invalid event_id", 400);
		}

		$attendance = pods( 'wcm-attendance', array(
			'where' => 't.event_id=' . $_POST['event_id'],
			'orderby' => 't.time_in'
		) );
		$output = array();

		if ( 0 < $attendance->total() ) {
			while ( $attendance->fetch() ) {
				$output[] = [
					'id' => $attendance->field( 'id' ),
					'patroller' => $attendance->display('patroller_id', true ),
					'type' => $attendance->field('type' ),
					'time_in' => $attendance->field('time_in' ),
					'time_out' => $attendance->field( 'time_out' ),
					'notes' => $attendance->field( 'notes' ),
					'can_delete' => current_user_can( 'pods_delete_wcm-attendance' )
				];
			}
		}

		$json = json_encode($output);

		echo $json;
		wp_die();
	}


	/**
	 * AJAX call to delete an attendance
	 */
	function attendance_delete() {
		if ( !current_user_can( 'pods_delete_wcm-attendance' ) ) {
			wp_send_json_error("You do not have sufficient permissions to delete an attendance", 403);
		}

		if ( !$_POST['attendance_id'] ) {
			wp_send_json_error("No attendance id was supplied", 400);
		}

		$attendance = pods( 'wcm-attendance', $_POST['attendance_id'] );

		if ( $attendance->delete() ) {
			wp_send_json_success( array(
				'message'   => 'Attendance deleted.',
				'id'        => $_POST['attendance_id']
			), 200);
		}
		else {
			wp_send_json_error("Attendance could not be deleted.", 400);
		}
	}
}

