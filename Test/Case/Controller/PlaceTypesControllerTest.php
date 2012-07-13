<?php
App::uses('PlaceTypesController', 'Places.Controller');

/**
 * TestPlaceTypesController *
 */
class TestPlaceTypesController extends PlaceTypesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * PlaceTypesController Test Case
 *
 */
class PlaceTypesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.place_type');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PlaceTypes = new TestPlaceTypesController();
		$this->PlaceTypes->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PlaceTypes);

		parent::tearDown();
	}

}
