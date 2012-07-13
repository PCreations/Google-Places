<?php

App::uses('HttpSocket', 'Network/Http');
App::uses('String', 'Utility');
App::uses('Set', 'Utility');

class GooglePlacesAPI {

	public $apiKey;

	public $HttpSocket;

	const PLACE_DETAIL_URL = "https://maps.googleapis.com/maps/api/place/details/";

/**
 * Constructor
 *
 */
	public function __construct() {
		//$this->controller = $collection->getController();
		$this->apiKey = Configure::read('GooglePlaces.key');
		$this->HttpSocket = new HttpSocket();
	}

	public function detail($reference, $sensor = false, $optionnalParameters = array(), $output = "json") {
		$key = $this->apiKey;
		$parameters = Set::merge(compact("reference", "sensor", "key"), $optionnalParameters);
		debug($parameters);
		$request = $this->HttpSocket->get(self::PLACE_DETAIL_URL . $output, $parameters);
		debug($request);
	}

}

?>