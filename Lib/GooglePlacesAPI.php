<?php

App::uses('Set', 'Utility');
App::uses('GooglePlacesRequest', 'GooglePlaces.Lib');
App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesAPI {

	public $apiKey;

	public $GooglePlacesRequest;

	const PLACE_DETAIL_URL = "https://maps.googleapis.com/maps/api/place/details/";

/**
 * Constructor
 *
 */
	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
		$this->GooglePlacesRequest = new GooglePlacesRequest();
	}

	public function detail($reference, $sensor = false, $optionnalParameters = array(), $output = "json") {
		$key = $this->apiKey;
		$parameters = Set::merge(compact("reference", "sensor", "key"), $optionnalParameters);
		$response = $this->GooglePlacesRequest->send(self::PLACE_DETAIL_URL, $output, $parameters);
		return $response->data->result;
	}

}

?>