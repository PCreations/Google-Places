<?php
class PlaceHandlerComponent extends Component {
	
	public $googlePlacesAPI;

	public $controller;

	public $modelClass;

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
		$this->modelClass = ($modelClass === false) ? $this->controller->modelClass : $modelClass;
		/*if(!$this->controller->{$modelClass}->Localization->validates()) {
			debug($this->controller->{$modelClass}->Localization->validationErrors);
		}*/
		if(!$this->controller->{$this->modelClass}->Behaviors->attached('GooglePlaces.Localizable')) {
			$this->controller->{$this->modelClass}->Behaviors->load('GooglePlaces.Localizable');
		}
		$this->controller->set('countries', $this->controller->{$this->modelClass}->getCountriesList());
		$this->controller->set('defaultCountry', 'fr');
		
	}

	public function beforeRender(Controller $controller) {
		$controller->set('localizationData', $controller->request->data['Localization']);
	}
}

?>