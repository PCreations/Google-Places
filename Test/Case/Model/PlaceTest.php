<?php
App::uses('Place', 'GooglePlaces.Model');

/**
 * Place Test Case
 *
 */
class PlaceTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.google_places.place', 'app.country', 'app.city', 'app.localized', 'app.place_type', 'app.place_types_place');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Place = ClassRegistry::init('Place');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Place);

		parent::tearDown();
	}

}
