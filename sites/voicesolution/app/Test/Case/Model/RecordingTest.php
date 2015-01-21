<?php
App::uses('Recording', 'Model');

/**
 * Recording Test Case
 *
 */
class RecordingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.recording',
		'app.company',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Recording = ClassRegistry::init('Recording');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Recording);

		parent::tearDown();
	}

}
