<?php
/**
 * LiveShotBOX : Broadcast Live Music (http://lsbox.com)
 * 
 * Licensed under Creative Commons BY-SA
 * Redistribution of files must retain the above copyright notice.
 *
 * @link	http://lsbox.com
 * @license CC BY-SA
 * @author Pierre Criulanscy
 */

/**
 * PlaceHandler Component
 *
 * This component is used to retrieve some data (like countries list) and append it to the current form.
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Controller.Component
 */
class PlaceHandlerComponent extends Component {

/**
 * Instance of GooglePlacesAPI
 *
 * @var GooglePlacesAPI
 */
	public $googlePlacesAPI;

/**
 * Current controller
 *
 * @var Controller
 */
	public $controller;

/**
 * Model's classname of the current controller
 *
 * @var string
 */
	public $modelClass;

/**
 * Defaults options for this component.
 * 
 * ### Possible keys
 *
 * - `initForm`: If set to true countries are retrieved during component initialization
 *
 * @var array
 */
	public $_defaults = array(
		'initForm' => true
	);

/**
 * Constructor
 *
 * @param object Controller object
 */
	public function __construct(ComponentCollection $collection, $settings) {
		$this->_defaults = Hash::merge($this->_defaults, $settings);
	}

/**
 * Component initialization.
 *
 * @param Controller $controller current Controller
 * @see PlaceHandlerComponent::initAutocompleteForm()
 */
	public function startup(Controller $controller) {
		$this->controller = $controller;
		if($this->_defaults['initForm']) {
			if(isset($this->_defaults['modelClass']))
				$this->initAutocompleteForm($this->_defaults['modelClass']);
			else
				$this->initAutocompleteForm();
		}
	}

/**
 * Autocomplete form initialization. The countries list is added and LocalizableBehavior is attached to current model.
 *
 * @param string $modelClass Model class name
 */
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
		//$controller->set('localizationData', $controller->request->data['Localization']);
	}
}

?>