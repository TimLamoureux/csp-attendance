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
			if ( function_exists( 'wpbp_get_template_part') ) {
				wpbp_get_template_part( CA_TEXTDOMAIN, 'content', 'attendance-manager', true );
			}
			else {
				get_template_part( 'content', 'attendance-manager' );
			}
			?>
		</div>

		<?php
		return ob_get_clean();
	}

}
