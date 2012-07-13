<?php
App::uses('PlaceType', 'GooglePlaces.Model');

/**
 * PlaceType Test Case
 *
 */
class PlaceTypeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.google_places.place_type', 'app.place', 'app.place_types_place');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PlaceType = ClassRegistry::init('PlaceType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PlaceType);

		parent::tearDown();
	}

}
