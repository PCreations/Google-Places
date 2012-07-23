<?php
App::uses('GooglePlacesAppController', 'GooglePlaces.Controller');
/**
 * Places Controller
 *
 */
class PlacesController extends GooglePlacesAppController {

	public $components = array('RequestHandler');

	public function handleCityAutocomplete() {
		$this->autoRender = false;
		
		/*if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}

		$place = json_decode($_POST['place']);
		$this->PlaceHandler->savePlace($place);*/
	}

	public function handleEstablishmentAutocomplete() {
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_GET);
		$predictions = $this->Place->getEstablishmentPredictionsByCity($term, $iso, $cityName, $lat, $lng);
		$this->set(compact("predictions"));
	}

	public function handleAddPlaceAutocomplete() {
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_GET);
		$predictions = $this->Place->getGeocodePredictionsByCity($term, $iso, $cityName, $lat, $lng);
		$this->set(compact("predictions"));
	}
}
