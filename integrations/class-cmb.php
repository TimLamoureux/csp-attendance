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
 * All the CMB related code.
 */
class Ca_CMB extends Ca_Base {

	/**
	 * Initialize CMB2.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
        parent::initialize();
		require_once(  CA_PLUGIN_ROOT . 'vendor/cmb2/init.php' );
		require_once(  CA_PLUGIN_ROOT . 'vendor/cmb2-grid/Cmb2GridPluginLoad.php' );
		add_action( 'cmb2_init', array( $this, 'cmb_demo_metaboxes' ) );
	}

	/**
	 * Your metabox on Demo CPT
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function cmb_demo_metaboxes() {
		// Start with an underscore to hide fields from custom fields list
		$prefix   = '_demo_';
		$cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Demo Metabox', CA_TEXTDOMAIN ),
			'object_types'  => array( 'demo' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
		) );
		$cmb2Grid = new \Cmb2Grid\Grid\Cmb2Grid( $cmb_demo );
		$row = $cmb2Grid->addRow();
		$field1 = $cmb_demo->add_field( array(
			'name' => __( 'Text', CA_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', CA_TEXTDOMAIN ),
			'id'   => $prefix . CA_TEXTDOMAIN . '_text',
			'type' => 'text',
				) );
		$field2 = $cmb_demo->add_field( array(
			'name' => __( 'Text 2', CA_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', CA_TEXTDOMAIN ),
			'id'   => $prefix . CA_TEXTDOMAIN . '_text2',
			'type' => 'text',
				) );

		$field3 = $cmb_demo->add_field( array(
			'name' => __( 'Text Small', CA_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', CA_TEXTDOMAIN ),
			'id'   => $prefix . CA_TEXTDOMAIN . '_textsmall',
			'type' => 'text_small',
				) );
		$field4 = $cmb_demo->add_field( array(
			'name' => __( 'Text Small 2', CA_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', CA_TEXTDOMAIN ),
			'id'   => $prefix . CA_TEXTDOMAIN . '_textsmall2',
			'type' => 'text_small',
		) );
		$row->addColumns( array( $field1, $field2 ) );
		$row = $cmb2Grid->addRow();
		$row->addColumns( array( $field3, $field4 ) );
	}

}
