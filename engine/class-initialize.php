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
 * Plugin Name Initializer
 */
class Ca_Initialize {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * List of class to initialize.
	 *
	 * @var object
	 */
	public $classes = null;

	/**
	 * The Constructor that load the entry classes
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
        $this->is        = new Ca_Is_Methods();
        $this->classes   = array();
        $this->classes[] = 'Ca_PostTypes';
        $this->classes[] = 'Ca_CMB';
        $this->classes[] = 'Ca_Cron';
        $this->classes[] = 'Ca_Template';
        $this->classes[] = 'Ca_Widgets';
        $this->classes[] = 'Ca_Rest';
        $this->classes[] = 'Ca_Transient';
		$this->classes[] = 'Ca_Ajax'; // Todo, load only for the frontend and when requiring ajax
		$this->classes[] = 'Ca_Attendance';
		$this->classes[] = 'Ca_Enqueue';
		$this->classes[] = 'Ca_Shortcode';


		$this->classes[] = 'Ca_Report';




		if ( $this->is->request( 'admin' ) ) {
            $this->classes[] = 'Ca_Admin_Notices';
            $this->classes[] = 'Ca_Admin_ImpExp';
        }

        if ( $this->is->request( 'frontend' ) ) {
            $this->classes[] = 'Ca_Extras';
        }

        $this->classes = apply_filters( 'ca_class_instances', $this->classes );

        return $this->load_classes();
    }

    private function load_classes() {
        foreach ( $this->classes as &$class ) {
            $class = apply_filters( strtolower( $class ) . '_instance', $class );
            $temp  = new $class;
            $temp->initialize();
        }
    }

    /**
     * Return an instance of this class.
     *
     * @since 1.0.0
     *
     * @return object A single instance of this class.
     */
    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null === self::$instance ) {
            try {
                self::$instance = new self;
            } catch ( Exception $err ) {
                do_action( 'csp_attendance_initialize_failed', $err );
                if ( WP_DEBUG ) {
                    throw new Exception($err->getMessage());
                }
            }
        }

        return self::$instance;
    }

}
