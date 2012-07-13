<?php
App::uses('PlaceTypesPlace', 'Places.Model');

/**
 * PlaceTypesPlace Test Case
 *
 */
class PlaceTypesPlaceTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.places.place_types_place', 'app.place_type', 'app.place');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PlaceTypesPlace = ClassRegistry::init('PlaceTypesPlace');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PlaceTypesPlace);

		parent::tearDown();
	}

}
