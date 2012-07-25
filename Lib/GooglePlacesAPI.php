<?php

App::uses('Set', 'Utility');
App::uses('GooglePlacesRequest', 'GooglePlaces.Lib');
App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesAPI {

	public $apiKey;

	public $GooglePlacesRequest;

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

	const PLACE_DETAIL_URL = "https://maps.googleapis.com/maps/api/place/details/";
	const PLACE_AUTOCOMPLETE_URL = "https://maps.googleapis.com/maps/api/place/autocomplete/";
	const PLACE_ADD_URL = "https://maps.googleapis.com/maps/api/place/add/";

/**
 * Constructor
 *
 */
	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
		$this->GooglePlacesRequest = new GooglePlacesRequest();
	}

	public function add($latitude, $longitude, $name, $types, $optionnalParameters = array(), $accuracy = 10, $sensor = false, $output = "json") {
		$location = array(
			'lat' => (double)$latitude,
			'lng' => (double)$longitude
		);
		$types = array($types);
		$parameters = Set::merge(compact('location', 'accuracy', 'name', 'types'), $optionnalParameters);
		$response = $this->sendRequest(self::PLACE_ADD_URL, $parameters, 'json', false, 'sensor='.(($sensor) ? 'true' : 'false').'&key='.$this->apiKey);
		return $response;
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

	private function sendRequest($url, $parameters, $output, $get = true, $urlSuffix = '') {
		$response = $this->GooglePlacesRequest->send($url, $output, $parameters, $get, $urlSuffix);
		return $response->data;
	}

}

?>