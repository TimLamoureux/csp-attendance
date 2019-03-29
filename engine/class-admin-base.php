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
class Ca_Admin_Base extends Ca_Base {

	/**
	 * Initialize the class
	 */
	public function initialize() {
        if ( is_admin() ) {
			add_filter( 'theme_page_templates', array($this, 'add_page_templates') );
            return parent::initialize();

		}

		return false;
	}

	/**
	 * Add all the page templates located in the folder page-templates
	 * Fired during loading of CSP_Attendance
	 * @since 		1.0.0
	 * @param 		array	$templates		Currently registered page templates
	 *
	 * @return 		array	The updated page templates
	 */
	public function add_page_templates( $templates ) {
		/* 	Workaround for improper detection of __FILE__ when debugging (xdebug)
		*	Per https://stackoverflow.com/questions/21254661/xdebug-weird-dir-constant
		*/
		$file = __FILE__;

		$files = glob(CA_PLUGIN_ROOT . 'templates/*.php');
		foreach( $files as $template ) {
			// Find the page template name from the file
			// Previous pattern to match if line ends with '*/': '/(?<=Template Name:\s).*(?=\s\*\/)/'
			$found = preg_match (
				'/(?<=Template Name:\s).*/',
				file_get_contents( $template, null, null, 0, 1024 ),
				$template_name
			);
			if ( 1 === $found ) {
				$templates[$template] = $template_name[0];
			}
		}

		return $templates;
	}

}

