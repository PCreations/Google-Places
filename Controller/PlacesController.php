<?php
App::uses('GooglePlacesAppController', 'GooglePlaces.Controller');
/**
 * Places Controller
 *
 */
class PlacesController extends GooglePlacesAppController {

	public $components = array('RequestHandler');

	public function getPlace() {
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		debug($_POST['place']);
	}

}
