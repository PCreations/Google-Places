<?php
class LoadModelException extends CakeException {
	protected $_messageTemplate = 'Unable to load %s model in %s.';
}

App::uses('GooglePlacesAPI', 'GooglePlaces.Lib');

class PlaceHandlerComponent extends Component {
	
	public $googlePlacesAPI;

	public $controller;

	public $_defaults;

/**
 * Constructor
 *
 * @param object Controller object
 */
	public function __construct(ComponentCollection $collection, $settings) {
		$this->_defaults = Set::merge($this->_defaults, $settings);
		$this->googlePlacesAPI = new GooglePlacesAPI(Configure::read('GooglePlaces.key'));
	}

	public function startup(Controller $controller) {
		$this->controller = $controller;
		if(isset($this->_defaults['modelClass']))
			$this->initAutocompleteForm($this->_defaults['modelClass']);
		else
			$this->initAutocompleteForm();
	}

	public function initAutocompleteForm($modelClass = false) {
		$modelClass = ($modelClass === false) ? $this->controller->modelClass : $modelClass;
		/*if(!$this->controller->{$modelClass}->Localization->validates()) {
			debug($this->controller->{$modelClass}->Localization->validationErrors);
		}*/
		$this->controller->set('countries', $this->controller->{$modelClass}->getCountriesList());
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