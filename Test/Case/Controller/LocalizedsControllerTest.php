<?php
App::uses('LocalizedsController', 'GooglePlaces.Controller');

/**
 * TestLocalizedsController *
 */
class TestLocalizedsController extends LocalizedsController {
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
 * LocalizedsController Test Case
 *
 */
class LocalizedsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.localized');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Localizeds = new TestLocalizedsController();
		$this->Localizeds->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Localizeds);

		parent::tearDown();
	}

}
