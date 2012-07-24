<?php
App::uses('GooglePlacesAppController', 'GooglePlaces.Controller');
/**
 * Places Controller
 *
 */
class PlacesController extends GooglePlacesAppController {

	public $components = array('RequestHandler');
	public $helpers = array('GooglePlaces.Places');

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

	public function handleAddPlace() {
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_POST);
		$this->set(compact("countriesInput", "country", "cityName"));
	}
}
