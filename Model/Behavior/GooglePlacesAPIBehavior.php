<?php

App::uses('GooglePlacesAPI', 'GooglePlaces.Lib');

class GooglePlacesAPIBehavior extends ModelBehavior {

	public $gpAPI;

	public function __construct() {
		parent::__construct();
		$this->gpAPI = new GooglePlacesAPI(Configure::read('GooglePlaces.key'));
	}

	public function gpAPI() {
		return $this->gpAPI;
	}

}
?>