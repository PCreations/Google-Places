<?php

App::uses('GooglePlacesAPI', 'GooglePlaces.Lib');

class GooglePlacesAPIBehavior extends ModelBehavior {

	public $api;

	public function setup($model, $options = array()) {
		$this->api = new GooglePlacesAPI(Configure::read('GooglePlaces.key'));
	}

}
?>