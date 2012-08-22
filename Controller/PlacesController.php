<?php
/**
 * LiveShotBOX : Broadcast Live Music (http://lsbox.com)
 * 
 * Licensed under Creative Commons BY-SA
 * Redistribution of files must retain the above copyright notice.
 *
 * @link	http://lsbox.com
 * @license CC BY-SA
 * @author Pierre Criulanscy (pcriulan@gmail.com)
 */

App::uses('GooglePlacesAppController', 'GooglePlaces.Controller');

/**
 * GooglePlaces Places Controller
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Controller	
 */
class PlacesController extends GooglePlacesAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler');
	
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('GooglePlaces.Places');


	/*public function handleCityAutocomplete() {
		$this->autoRender = false;
		
		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}

		$place = json_decode($_POST['place']);
		$this->PlaceHandler->savePlace($place);
	}*/

/**
 * Handles establishement places autocomplete
 *
 * This method is an ajax callback to handle establishment autocomplete. See Place::getPlacePredictionsByCity() for details.
 */
	public function handleEstablishmentAutocomplete() {
		$this->view = 'predictions_json';

		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		
		extract($_GET);
		$predictions = $this->Place->getPlacePredictionsByCity($term, $iso, $cityName, 'establishment', __('Add new place : :input'), $lat, $lng);
		$this->set(compact("predictions"));

	}

/**
 * Handles geocode (address) places autocomplete
 *
 * This method is an ajax callback to handle geocode autocomplete. See Place::getPlacePredictionsByCity() for details.
 */
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
		$types = array_combine(array_keys(array_flip($types)), $types);
		$this->set(compact("countriesInput", "country", "cityName", "types"));
	}

/**
 * Get geocode's details.
 *
 * Ajax callback, return geocode's details in json format
 */
	public function geocodeDetails() {

		if(!$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}

		extract($_GET);
		$geocodeDetails = $this->Place->gpAPI()->detail($geocodeReference);
		$this->set(compact("geocodeDetails"));
		$this->set('_serialize', array('geocodeDetails'));
	}

	public function test() {
		$this->autoRender = false;
		var_dump($_POST);
	}
}
