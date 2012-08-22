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

App::uses('GooglePlacesAppModel', 'GooglePlaces.Model');

/**
 * Place Model
 *
 * @package GooglePlaces
 * @subpackage GooglePlaces.Model
 */
class Place extends GooglePlacesAppModel {

	public $actsAs = array('Containable', 'GooglePlaces.GooglePlacesAPI');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Country' => array(
			'className' => 'GooglePlaces.Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PlaceIn' => array(
			'className' => 'GooglePlaces.Place',
			'foreignKey' => 'place_id',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Localized' => array(
			'className' => 'GooglePlaces.Localized',
			'foreignKey' => 'place_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'PlaceType' => array(
			'className' => 'PlaceType',
			'joinTable' => 'place_types_places',
			'with' => 'PlaceTypesPlace',
			'foreignKey' => 'place_id',
			'associationForeignKey' => 'place_type_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

/**
 * Place routine. Checks if place (city) already exists in db and if not adds it and it's types
 *
 * @param string $placeID The place's id
 * @param string $placeReference The place's reference
 * @param string $countryID The country's id
 * @see Place::routine()
 */
	public function placeRoutine($placeID, $placeReference, $countryID) {
		if(!$this->routine($placeID, $placeReference)) {
			/* Add the place */
			$PlaceTypesPlace = ClassRegistry::init('GooglePlaces.PlaceTypesPlace');
			$PlaceTypesPlace->savePlaceAndTypes($this->gpAPI()->detail($placeReference), $countryID);
		}
	}

/**
 * Establishment routine. Checks if establishment already exists in db and if not adds it and it's types
 *
 * @param string $establishmentID The establishment's id
 * @param string $establishmentReference The establishment's reference
 * @param string $placeID The place's id (the city)
 * @param string $countryID The country's id
 * @see Place::routine()
 */
	public function establishmentRoutine($establishmentID, $establishmentReference, $placeID, $countryID) {
		if(!$this->routine($establishmentID, $establishmentReference)) {
			/* Add the establishment */
			$PlaceTypesPlace = ClassRegistry::init('GooglePlaces.PlaceTypesPlace');
			$PlaceTypesPlace->saveEstablishment($this->gpAPI()->detail($establishmentReference), $placeID, $countryID);
		}
	}

/**
 * Routine when getting place's details. Checks if place already exists, if not place is added, otherwise the function checks for place's id update
 *
 * @param string $id place's id
 * @param string $reference place's reference
 * @return boolean true if place already exists in db
 * @see Place::isAlreadyExists()
 * @see Place::updatePlaceId()
 */
	private function routine($id, $reference) {
		$details = $this->gpAPI()->detail($reference);

		/* Check if place already exists in db */
		if($this->isAlreadyExists($id)) {
			/* Check for update id */
			if($details->id != $id) {

				$id = $this->updatePlaceId($id, $details->id);
			}
			return true;
		}
		return false;
	}

/**
 * Checks if place already exists in db
 *
 * @param string $id place's id
 * @return boolean true if place already exists in db
 */
	public function isAlreadyExists($id) {
		$result = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				'Place.id' => $id
			)
		));
		return !empty($result);
	}

/**
 * Updates place's id if needed
 *
 * @param string $oldID The old place's id
 * @param string $newID The new place's id
 */
	public function updatePlaceId($oldId, $newId) {
		$this->read(null, $oldId);
		$this->set('id', $newId);
		$this->save();
	}

/**
 * Retrieves place's predictions within specified city
 *
 * @param string $input The user input
 * @param string $iso2 The alpha-2 ISO 3166-1 country code
 * @param string $cityName The city name. Used to prepend user input in order to filter by city (impossible for now directly with Google Places component restrictions)
 * @param string $type The place's type
 * @param string $templateNoResult The text will be prompted in autocomplete if there is no result. ":input" will be replaced by the user input
 * @param double $lat The biasing lattitude to restrict result around specific radius
 * @param double $lng The biasing longitude to restrict result around specific radius
 * @param int $radius The radius for biasing
 * @return array Array of predictions formatted to suit JqueryUI autocomplete conventions
 */
	public function getPlacePredictionsByCity($input, $iso2, $cityName, $type, $templateNoResult = 'No result for :input', $lat = null, $lng = null, $radius = 500000) {
		$optionnalParameters = array(
			'components' => 'country:' . strtolower($iso2),
			'types' => $type,
			'location' => "$lat,$lng",
			'radius' => $radius
		);

		if($lat == null || $lng == null) {
			unset($optionnalParameters['location']);
		}

		/* CityName is prepend to input in order to restrict results */
		$predictions = $this->gpAPI()->autocomplete($cityName . ' ' .$input, $sensor = false, $optionnalParameters);

		foreach($predictions as &$prediction) {
			$prediction = array(
				'id' => $prediction->id . '|' . $prediction->reference,
				'label' => $prediction->description
			);	
		}
		$templateNoResult = String::insert($templateNoResult, array('input' => $input));
		return empty($predictions) ? array(array('id' => '-1', 'label' => $templateNoResult)) : $predictions;
	}

/**
 * Retrieves geocode's predictions within specified city
 *
 * @param string $input The user input
 * @param string $iso2 The alpha-2 ISO 3166-1 country code
 * @param string $cityName The city name. Used to prepend user input in order to filter by city (impossible for now directly with Google Places component restrictions)
 * @param double $lat The biasing lattitude to restrict result around specific radius
 * @param double $lng The biasing longitude to restrict result around specific radius
 * @param int $radius The radius for biasing
 * @return array Array of predictions formatted to suit JqueryUI autocomplete conventions
 */
	public function getGeocodePredictionsByCity($input, $iso2, $cityName, $lat, $lng, $radius = 50000, $force = false) {
		$optionnalParameters = array(
			'components' => 'country:' . strtolower($iso2),
			'type' => 'geocode',
			'location' => "$lat,$lng",
			'radius' => $radius
		);
		$predictions = $this->gpAPI()->autocomplete($input, $sensor = false, $optionnalParameters);
		
		/* If there are predictions, cityName is prepend to input in order to restrict results */
		if(!empty($predictions)) {
			$newPredictions = $this->gpAPI()->autocomplete($cityName . ' ' .$input, $sensor = false, $optionnalParameters);
			if(!empty($newPredictions))
				$predictions = $newPredictions;
		}

		$restrictedPredictions = array();
		foreach($predictions as $prediction) {
			//$placeDetail = $this->gpAPI()->detail($prediction->reference);
			/* Checks if city name is found in description TODO: regexp */
			if(stripos($prediction->description, $cityName) !== false) {
				$restrictedPredictions[] = array(
							'id' => $prediction->id . '|' . $prediction->reference,
							'label' => $prediction->description
						);	
			}
		}
		//$restrictedPredictions = $predictions;
		return ($force === false) ? (empty($restrictedPredictions) ? array('id' => '-1', 'label' => __('No results for ' . $input)) : $restrictedPredictions) : $predictions;
	}

}
