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
	}

	public function getEstablishmentPredictionsByCity($input, $iso2, $cityName, $lat, $lng, $radius = 50000, $force = false) {
		$optionnalParameters = array(
			'components' => 'country:' . strtolower($iso2),
			'type' => 'establishment',
			'location' => "$lat,$lng",
			'radius' => $radius
		);
		$predictions = $this->googlePlacesAPI->autocomplete($input, $sensor = false, $optionnalParameters);
		
		/* If there are predictions, cityName is append to input in order to restrict results */
		if(!empty($predictions)) {
			$newPredictions = $this->googlePlacesAPI->autocomplete($input.' '.$cityName, $sensor = false, $optionnalParameters);
			if(!empty($newPredictions))
				$predictions = $newPredictions;
		}

		$restrictedPredictions = array();
		foreach($predictions as $prediction) {
			//$placeDetail = $this->googlePlacesAPI->detail($prediction->reference);
			if(stripos($prediction->description, $cityName) !== false) {
				$restrictedPredictions[] = array(
							'id' => $prediction->id,
							'label' => $prediction->description
						);	
			}
			/*foreach($placeDetail->address_components as $addressComponent) {
				$longName = $addressComponent->long_name;
				if($addressComponent->long_name == $cityName) {
					if(array_search('locality', $addressComponent->types) !== false)
						$restrictedPredictions[] = array(
							'id' => $prediction->id,
							'label' => $prediction->description
						);	
				}
			}*/
		}
		//$restrictedPredictions = $predictions;
		return ($force === false) ? (empty($restrictedPredictions) ? array('id' => '-1', 'label' => __('No results for ' . $input)) : $restrictedPredictions) : $predictions;
	}

}

?>