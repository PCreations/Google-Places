<?php
App::uses('PlacesAppController', 'Places.Controller');
/**
 * Places Controller
 *
 */
class PlacesController extends PlacesAppController {

	public $components = array('RequestHandler');

	public function getPlace() {
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		debug($_POST['place']);
	}

}
