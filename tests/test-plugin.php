<?php
/**
 * Class SampleTest
 *
 * @package Simple_Amp
 */

/**
 * Sample test case.
 */
class TestSimpleAmp extends WP_UnitTestCase {

	public $instance;

	public function setUp() {
		$this->instance = new Simple_AMP();
		$this->instance->setup();
		parent::setUp();
	}

	/**
	 * A single example test.
	 */
	function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}

	public function test_requirement() {
		$this->assertTrue( Simple_AMP_Helper::requirements_check() );
	}

	public function test_init() {
		$this->assertInstanceOf( 'Simple_AMP', $this->instance );
	}

	public function test_amp_url() {
		$_SERVER['SERVER_PORT'] = 80;
		$_SERVER["SERVER_NAME"] = 'example.org';

		$url = 'http://example.org/amp';
		$this->assertEquals( $url, $this->instance->get_amp_url() );
	}


}
