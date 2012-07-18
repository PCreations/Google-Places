<?php
App::uses('GooglePlacesAppController', 'GooglePlaces.Controller');
/**
 * Places Controller
 *
 */
class PlacesController extends GooglePlacesAppController {

	public $components = array('RequestHandler', 'GooglePlaces.PlaceHandler' => array('initForm' => false));

	public function handleCityAutocomplete() {
		$this->autoRender = false;
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}

		$place = json_decode($_POST['place']);
		$this->PlaceHandler->savePlace($place);
	}

	public function handleEstablishmentAutocomplete() {
		$this->autoRender = false;

		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}

		$cityID = $_POST['cityID'];

		$this->PlaceHandler->getEstablishmentPredictionsByCity($cityID);
	}
}
