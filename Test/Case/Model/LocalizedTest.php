<?php
App::uses('Localized', 'Places.Model');

/**
 * Localized Test Case
 *
 */
class LocalizedTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.places.localized', 'app.place');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Localized = ClassRegistry::init('Localized');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Localized);

		parent::tearDown();
	}

}
