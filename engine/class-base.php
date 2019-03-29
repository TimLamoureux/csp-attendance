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
 * This class is the base skeleton of the plugin
 */
class Ca_Base {

	/**
	 * The settings of the plugin
	 */
	public $settings = array();

	/**
	 * Initialize the class
	 */
	public function initialize() {
		$this->settings = ca_get_settings();
		return true;
	}



}
