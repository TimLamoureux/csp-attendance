<?php

class InitializeAdminTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp() {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

        $user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$user = wp_set_current_user( $user_id );
		set_current_screen( 'edit.php' );
	}

	public function tearDown() {
		parent::tearDown();
	}

	private function make_instance() {
		return new Ca_Initialize();
	}

	/**
	 * @test
	 * it should be admin
	 */
	public function it_should_be_admin() {
		$sut = $this->make_instance();

		$classes   = array();
		$classes[] = 'Ca_PostTypes';
		$classes[] = 'Ca_CMB';
		$classes[] = 'Ca_Cron';
		$classes[] = 'Ca_FakePage';
		$classes[] = 'Ca_Template';
		$classes[] = 'Ca_Widgets';
		$classes[] = 'Ca_Rest';
		$classes[] = 'Ca_Transient';
 		$classes[] = 'Ca_Ajax';
 		$classes[] = 'Ca_Ajax_Admin';
		$classes[] = 'Ca_Pointers';
		$classes[] = 'Ca_ContextualHelp';
		$classes[] = 'Ca_Admin_ActDeact';
		$classes[] = 'Ca_Admin_Notices';
		$classes[] = 'Ca_Admin_Settings_Page';
		$classes[] = 'Ca_Admin_Enqueue';
		$classes[] = 'Ca_Admin_ImpExp';
		$classes[] = 'Ca_Enqueue';
		$classes[] = 'Ca_Extras';

		$this->assertTrue( is_admin() );
		$this->assertEquals( $classes, $sut->classes );
	}

}
