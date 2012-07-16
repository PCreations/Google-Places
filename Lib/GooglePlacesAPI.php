<?php

App::uses('HttpSocket', 'Network/Http');
App::uses('String', 'Utility');
App::uses('Set', 'Utility');
App::uses('GooglePlacesRequest', 'GooglePlaces.Lib');
App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesAPI {

	public $apiKey;

	public $HttpSocket;

	const PLACE_DETAIL_URL = "https://maps.googleapis.com/maps/api/place/details/";

/**
 * Constructor
 *
 */
	public function __construct($apiKey = null) {
		//$this->controller = $collection->getController();
		$this->apiKey = ($apiKey == null) ? Configure::read('GooglePlaces.key') : $apiKey;
		$this->HttpSocket = new HttpSocket();
	}

	public function detail($reference, $sensor = false, $optionnalParameters = array(), $output = "json") {
		$key = $this->apiKey;
		$parameters = Set::merge(compact("reference", "sensor", "key"), $optionnalParameters);
		debug($parameters);
		$request = new GooglePlacesRequest(self::PLACE_DETAIL_URL, $output, $parameters);
		try {
			$response = $request->send();
		}
		catch(GooglePlacesException $e) {
			die($e->getMessage());
		}
		var_dump($response->data);
	}

	private function request($url) {
		
	}

}

?>