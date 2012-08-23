<?php
/**
 * GooglePlaces Plugin
 * 
 * Licensed under Creative Commons BY-SA
 * Redistribution of files must retain the above copyright notice.
 *
 * @link	
 * @license CC BY-SA
 * @author Pierre Criulanscy
 */

App::uses('Set', 'Utility');
App::uses('GooglePlacesRequest', 'GooglePlaces.Lib');
App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

/**
 * GooglePlacesAPI to interact with GooglePlaces web services
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Lib
 */

class GooglePlacesAPI {

/**
 * Developper's api key
 *
 * @var string
 */
	public $apiKey;

/**
 * GooglePlacesRequest instance
 *
 * @var GooglePlacesRequest
 * @see GooglePlacesRequest
 */
	public $GooglePlacesRequest;

/**
 * List of supported place types for adding request
 *
 * @var array
 */
	public $addSupportedPlaceTypes = array(
		'accounting',
		'airport',
		'amusement_park',
		'aquarium',
		'art_gallery',
		'atm',
		'bakery',
		'bank',
		'bar',
		'beauty_salon',
		'bicycle_store',
		'book_store',
		'bowling_alley',
		'bus_station',
		'cafe',
		'campground',
		'car_dealer',
		'car_rental',
		'car_repair',
		'car_wash',
		'casino',
		'cemetery',
		'church',
		'city_hall',
		'clothing_store',
		'convenience_store',
		'courthouse',
		'dentist',
		'department_store',
		'doctor',
		'electrician',
		'electronics_store',
		'embassy',
		'establishment',
		'finance',
		'fire_station',
		'forist',
		'food',
		'funeral_home',
		'furniture_store',
		'gas_station',
		'general_contractor',
		'grocery_or_supermarket',
		'gym',
		'hair_care',
		'hardware_store',
		'health',
		'hindu_temple',
		'home_goods_store',
		'hospital',
		'insurance_agency',
		'jewelry_store',
		'laundry',
		'lawyer',
		'library',
		'liquor_store',
		'local_government_office',
		'locksmith',
		'lodging',
		'meal_delivery',
		'meal_takeaway',
		'mosque',
		'movie_rental',
		'movie_theater',
		'moving_company',
		'museum',
		'night_club',
		'painter',
		'park',
		'parking',
		'pet_store',
		'pharmacy',
		'physiotherapist',
		'place_of_whorship',
		'plumber',
		'police',
		'post_office',
		'real_estate_agency',
		'restaurant',
		'roofing_contractor',
		'rv_park',
		'school',
		'shoe_store',
		'shopping_mall',
		'spa',
		'stadium',
		'storage',
		'store',
		'subway_station',
		'synagogue',
		'taxi_stand',
		'train_station',
		'travel_agency',
		'university',
		'veterinary_care',
		'zoo'
	);

/**
 * Google place web service url to retrieve place details
 *
 * @var const PLACE_DETAIL_URL
 */
	const PLACE_DETAIL_URL = "https://maps.googleapis.com/maps/api/place/details/";

/**
 * Google place web service url to retrieve places predictions (autocomplete suggestions)
 *
 * @var const PLACE_AUTOCOMPLETE_URL
 */
	const PLACE_AUTOCOMPLETE_URL = "https://maps.googleapis.com/maps/api/place/autocomplete/";

/**
 * Google place web service url to add place
 *
 * @var const PLACE_ADD_URL
 */
	const PLACE_ADD_URL = "https://maps.googleapis.com/maps/api/place/add/";

/**
 * Constructor
 *
 * @param string $apiKey the developper api key
 */
	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
		$this->GooglePlacesRequest = new GooglePlacesRequest();
	}

/**
 * Sends request to report place in Google database
 *
 * @param double $latitude The place's latitude
 * @param double $longitude The place's longitude
 * @param string $name The place's name
 * @param array $types Array of place's types
 * @param array $optionnalParameters Array of optionnalParameters
 * ### Possible optionnal parameters
 *
 * - `language`: The language in which the Place's name is being reported. See the list of supported languages and their codes. Note that we often update supported languages so this list may not be exhaustive (https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1)
 * @param int $accuracy The accuracy of the location signal on which this request is based, expressed in meters
 * @param boolean $sensor Indicates whether or not the Place request came from a device using a location sensor (e.g. a GPS) to determine the location sent in this request. This value must be either true or false
 * @param output $output Response output (json or xml)
 * @return GooglePlacesResponse	$response Instance of GooglePlacesResponse
 * @see GooglePlacesResponse::__construct()
 */
	public function add($latitude, $longitude, $name, $types, $optionnalParameters = array(), $accuracy = 10, $sensor = false, $output = "json") {
		$location = array(
			'lat' => (double)$latitude,
			'lng' => (double)$longitude
		);
		$types = array($types);
		$parameters = Hash::merge(compact('location', 'accuracy', 'name', 'types'), $optionnalParameters);
		$response = $this->sendRequest(self::PLACE_ADD_URL, $parameters, 'json', false, 'sensor='.(($sensor) ? 'true' : 'false').'&key='.$this->apiKey);
		return $response;
	}

/**
 * Sends request to get place details
 *
 * @param string $reference The place's reference
 * @param boolean $sensor Indicates whether or not the Place request came from a device using a location sensor (e.g. a GPS) to determine the location sent in this request. This value must be either true or false
 * @param array $optionnalParameters Array of optionnalParameters
 * ### Possible optionnal parameters
 *
 * - `language`: The language in which the Place's name is being reported. See the list of supported languages and their codes. Note that we often update supported languages so this list may not be exhaustive (https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1)
 * @param output $output Response output (json or xml)
 * @return string $result the response's result
 * @see GooglePlacesResponse::__construct()
 */
	public function detail($reference, $sensor = false, $optionnalParameters = array(), $output = "json") {
		$key = $this->apiKey;
		$parameters = Hash::merge(compact("reference", "sensor", "key"), $optionnalParameters);
		$response = $this->sendRequest(self::PLACE_DETAIL_URL, $parameters, $output);
		return $response->result;
	}

/**
 * Sends request to get place's predictions
 *
 * @param string $input The input text
 * @param boolean $sensor Indicates whether or not the Place request came from a device using a location sensor (e.g. a GPS) to determine the location sent in this request. This value must be either true or false
 * @param array $optionnalParameters Array of optionnalParameters
 * ### Possible optionnal parameters
 *
 * - `language`: The language in which the Place's name is being reported. See the list of supported languages and their codes. Note that we often update supported languages so this list may not be exhaustive (https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1)
 * @param output $output Response output (json or xml)
 * @return string $data The response predictions
 */
	public function autocomplete($input, $sensor = false, $optionnalParameters = array(), $output = "json") {
		$key = $this->apiKey;
		$input = urlencode($input);
		$parameters = Hash::merge(compact("input", "sensor", "key"), $optionnalParameters);
		$response = $this->sendRequest(self::PLACE_AUTOCOMPLETE_URL, $parameters, $output);
		return isset($response->predictions) ? $response->predictions : null;
	}

/**
 * Uses GooglePlacesRequest to send request to Google Places API
 *
 * @param string $url The api url
 * @param array $parameters Array of url params
 * @param string $output Response format (json/xml)
 * @param boolean $get If set to true a GET request will be sent
 * @param string $urlSuffix Additionnals things to append to url
 * @return string $data The response data
 * @see GooglePlacesRequest::send()
 */
	private function sendRequest($url, $parameters, $output, $get = true, $urlSuffix = '') {
		$response = $this->GooglePlacesRequest->send($url, $output, $parameters, $get, $urlSuffix);
		return $response->data;
	}

}

?>