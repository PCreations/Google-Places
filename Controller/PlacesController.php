<?php
App::uses('GooglePlacesAppController', 'GooglePlaces.Controller');
/**
 * Places Controller
 *
 */
class PlacesController extends GooglePlacesAppController {

	public $components = array('RequestHandler', 'GooglePlaces.PlaceHandler');

	public function handleAutocomplete() {
		$this->autoRender = false;
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		$place = json_decode($_POST['place']);
		$this->PlaceHandler->savePlace($place);
	}
}
