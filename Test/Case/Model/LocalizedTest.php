<?php
App::uses('Localized', 'GooglePlaces.Model');

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
	public $fixtures = array('plugin.google_places.localized', 'app.place');

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
