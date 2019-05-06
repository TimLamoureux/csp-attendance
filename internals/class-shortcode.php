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
 * This class contain all the snippet or extra that improve the experience on the frontend
 */
class Ca_Shortcode extends Ca_Base {

	/**
	 * Initialize the snippet
	 */
	public function initialize() {
		parent::initialize();
		//add_shortcode( 'foobar', array( $this, 'foobar_func' ) );
		add_shortcode( 'ca_manager', array( $this, 'attendance_manager' ) );
		add_shortcode( 'ca_report_form', array( $this, 'generate_report_form' ) );
	}

	/**
	 * Shortcode to output the attendance manager
	 *
	 * @param array $atts Parameters.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function attendance_manager( $atts ) {
		/*shortcode_atts(
			array(
				'foo' => 'something',
				'bar' => 'something else',
			), $atts
		);*/

		// TODO: Use filters and actions to output the template parts. None of this should be in the shortcode code directly

		ob_start();
		?>

        <div>
            <h3>Attendance manager</h3>
			<?php
			/**
			 * TODO: should locate file instead of use template part. The reason is because if the part is not foud,
			 * It will default to Content Template instead.
			 */
			if ( function_exists( 'wpbp_get_template_part' ) ) {
				wpbp_get_template_part( CA_TEXTDOMAIN, 'content', 'attendance-manager', true );
			} else {
				get_template_part( 'content', 'attendance-manager' );
			}
			?>
        </div>

		<?php
		return ob_get_clean();
	}

	/**
	 * Shortcode to output a user's attendance
	 *
	 * @param array $atts Parameters.
	 *
	 * @since 1.0.1
	 *
	 * @return string
	 */
	public static function my_attendance( $atts ) {
		shortcode_atts(
			array(
				'user_id' => get_current_user_id(),
				'from' => mktime(
					0,
					0,
					0,
					date( 'm' ) - 1,
                    date( 'd' ),
					date( 'Y' )
				),
				'to' => mktime()
			), $atts
		);
	}

	function generate_report_form( $atts ) {

		ob_start();
		//load_template( wpbp_get_template_part( CA_TEXTDOMAIN, 'report', 'form', false ) );
		wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'report-form', true );

		return ob_get_clean();
	}
}
