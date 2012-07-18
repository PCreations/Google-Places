<?php

App::uses('Set', 'Utility');
App::uses('GooglePlacesRequest', 'GooglePlaces.Lib');
App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesAPI {

	public $apiKey;

	public $GooglePlacesRequest;

	const PLACE_DETAIL_URL = "https://maps.googleapis.com/maps/api/place/details/";
	const PLACE_AUTOCOMPLETE_URL = "https://maps.googleapis.com/maps/api/place/autocomplete/";

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
		$response = $this->sendRequest(self::PLACE_DETAIL_URL, $parameters, $output);
		return $response->result;
	}

	public function autocomplete($input, $sensor = false, $optionnalParameters = array(), $output = "json") {
		$key = $this->apiKey;
		$input = urlencode($input);
		$parameters = Set::merge(compact("input", "sensor", "key"), $optionnalParameters);
		$response = $this->sendRequest(self::PLACE_AUTOCOMPLETE_URL, $parameters, $output);
		return isset($response->predictions) ? $response->predictions : null;
	}

	private function sendRequest($url, $parameters, $output) {
		$response = $this->GooglePlacesRequest->send($url, $output, $parameters);
		return $response->data;
	}

}

?>