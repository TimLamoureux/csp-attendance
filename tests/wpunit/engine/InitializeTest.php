<?php

class InitializeTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp() {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

        wp_set_current_user(0);
        wp_logout();
        wp_safe_redirect(wp_login_url());
	}

	public function tearDown() {
		parent::tearDown();
	}

	private function make_instance() {
		return new Ca_Initialize();
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();
		$this->assertInstanceOf( 'Ca_Initialize', $sut );
	}

	/**
	 * @test
	 * it should be front
	 */
	public function it_should_be_front() {
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
		$classes[] = 'Ca_Enqueue';
		$classes[] = 'Ca_Extras';

		$this->assertEquals( $classes, $sut->classes );
	}

}
