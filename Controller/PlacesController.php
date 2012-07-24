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
		$this->view = 'predictions_json';

		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_GET);
		$predictions = $this->Place->getPlacePredictionsByCity($term, $iso, $cityName, 'establishment', __('Add new place : :input'), $lat, $lng);
		$this->set(compact("predictions"));

	}

	public function handleGeocodeAutocomplete() {
		$this->view = 'predictions_json';

		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_GET);
		$predictions = $this->Place->getPlacePredictionsByCity($term, $iso, $cityName, 'geocode', __('No results for : :input'));
		$this->set(compact("predictions"));
	}

	public function handleAddPlace() {
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_POST);
		$types = $this->Place->gpAPI()->addSupportedPlaceTypes;
		$this->set(compact("countriesInput", "country", "cityName", "types"));
	}

	public function geocodeDetails() {

		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}

		extract($_GET);
		$geocodeDetails = $this->Place->gpAPI()->detail($geocodeReference);
		$this->set(compact("geocodeDetails"));
		$this->set('_serialize', array('geocodeDetails'));
	}
}
