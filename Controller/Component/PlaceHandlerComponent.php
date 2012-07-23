<?php
class PlaceHandlerComponent extends Component {
	
	public $googlePlacesAPI;

	public $controller;

	public $_defaults = array(
		'initForm' => true
	);

/**
 * Constructor
 *
 * @param object Controller object
 */
	public function __construct(ComponentCollection $collection, $settings) {
		$this->_defaults = Set::merge($this->_defaults, $settings);
	}

	public function startup(Controller $controller) {
		$this->controller = $controller;
		if($this->_defaults['initForm']) {
			if(isset($this->_defaults['modelClass']))
				$this->initAutocompleteForm($this->_defaults['modelClass']);
			else
				$this->initAutocompleteForm();
		}
	}

	public function initAutocompleteForm($modelClass = false) {
		$modelClass = ($modelClass === false) ? $this->controller->modelClass : $modelClass;
		/*if(!$this->controller->{$modelClass}->Localization->validates()) {
			debug($this->controller->{$modelClass}->Localization->validationErrors);
		}*/
		if(!$this->controller->{$modelClass}->Behaviors->attached('GooglePlaces.Localizable')) {
			$this->controller->{$modelClass}->Behaviors->load('GooglePlaces.Localizable');
		}
		$this->controller->set('countries', $this->controller->{$modelClass}->getCountriesList());
		$this->controller->set('defaultCountry', $this->controller->{$modelClass}->getCountryFromLocale());
	}

}

?>