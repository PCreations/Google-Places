<?php
class LoadModelException extends CakeException {
	protected $_messageTemplate = 'Unable to load %s model in %s.';
}

App::uses('GooglePlacesAPI', 'GooglePlaces.Lib');

class PlaceHandlerComponent extends Component {
	
	public $components = array('GooglePlaces.GooglePlacesAPI');

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
		$this->googlePlacesAPI = new GooglePlacesAPI();
	}

	public function savePlace($place) {
		$place = json_decode($place);
		if(!$this->controller->loadModel('GooglePlaces.Place')) {
			throw new LoadModelException(array(
				'model' => 'GooglePlaces.Place',
				'controller' => $this->controller->name
			));
		}
		/* Check if place already exists in db */
		if($this->controller->Place->isAlreadyExists($place->id)) {
			/* Check for update id */
			$this->googlePlacesAPI->detail($place->reference);
		}
	}

}

?>