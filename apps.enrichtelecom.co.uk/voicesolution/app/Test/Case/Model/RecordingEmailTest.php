<?php
App::uses('RecordingEmail', 'Model');

/**
 * RecordingEmail Test Case
 *
 */
class RecordingEmailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.recording_email',
		'app.record'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RecordingEmail = ClassRegistry::init('RecordingEmail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RecordingEmail);

		parent::tearDown();
	}

}
