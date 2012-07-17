<?php
class LoadModelException extends CakeException {
	protected $_messageTemplate = 'Unable to load %s model in %s.';
}

App::uses('GooglePlacesAPI', 'GooglePlaces.Lib');

class PlaceHandlerComponent extends Component {
	
	public $googlePlacesAPI;

	public $controller;

/**
 * Constructor
 *
 * @param object Controller object
 */
	public function __construct(ComponentCollection $collection, $settings) {
		$this->controller = $collection->getController();
		$this->_defaults = Set::merge($this->_defaults, $settings);
		$this->googlePlacesAPI = new GooglePlacesAPI(Configure::read('GooglePlaces.key'));
	}

	public function initAutocompleteForm() {
		$this->controller->set('countries', $this->controller->{$this->controller->modelClass}->getCountriesList());
	}

	public function savePlace($place) {
		if(!$this->controller->loadModel('GooglePlaces.Place')) {
			throw new LoadModelException(array(
				'model' => 'GooglePlaces.Place',
				'controller' => $this->controller->name
			));
		}
		/* Check if place already exists in db */
		if($this->controller->Place->isAlreadyExists($place->id)) {
			/* Check for update id */
			$placeDetails = $this->googlePlacesAPI->detail($place->reference);
			if($placeDetails->id != $place->id) {

				$place->id = $this->controller->Place->updatePlaceId($place->id, $placeDetails->id);
			}
		}
		else { /* Else let's add the place */
			$this->controller->loadModel('GooglePlaces.PlaceTypesPlace');
			$this->controller->PlaceTypesPlace->savePlaceAndTypes($place);
		}
	}

}

?>