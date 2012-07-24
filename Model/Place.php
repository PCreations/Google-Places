<?php
App::uses('GooglePlacesAppModel', 'GooglePlaces.Model');
/**
 * Place Model
 *
 * @property Country $Country
 * @property Localized $Localized
 * @property PlaceType $PlaceType
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

	public function placeRoutine($placeID, $placeReference, $countryID) {
		if(!$this->routine($placeID, $placeReference)) {
			/* Add the place */
			$PlaceTypesPlace = ClassRegistry::init('GooglePlaces.PlaceTypesPlace');
			$PlaceTypesPlace->savePlaceAndTypes($this->gpAPI()->detail($placeReference), $countryID);
		}
	}

	public function establishmentRoutine($establishmentID, $establishmentReference, $placeID, $countryID) {
		if(!$this->routine($establishmentID, $establishmentReference)) {
			/* Add the establishment */
			$PlaceTypesPlace = ClassRegistry::init('GooglePlaces.PlaceTypesPlace');
			$PlaceTypesPlace->saveEstablishment($this->gpAPI()->detail($establishmentReference), $placeID, $countryID);
		}
	}

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

	public function isAlreadyExists($id) {
		$result = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				'Place.id' => $id
			)
		));
		return !empty($result);
	}

	public function updatePlaceId($oldId, $newId) {
		$this->read(null, $oldId);
		$this->set('id', $newId);
		$this->save();
	}

	public function getEstablishmentPredictionsByCity($input, $iso2, $cityName, $lat, $lng, $radius = 50000, $force = false) {
		$optionnalParameters = array(
			'components' => 'country:' . strtolower($iso2),
			'types' => 'establishment',
			'location' => "$lat,$lng",
			'radius' => $radius
		);

		/* CityName is prepend to input in order to restrict results */
		$predictions = $this->gpAPI()->autocomplete($cityName . ' ' .$input, $sensor = false, $optionnalParameters);

		foreach($predictions as &$prediction) {
			$prediction = array(
				'id' => $prediction->id . '|' . $prediction->reference,
				'label' => $prediction->description
			);	
		}
		return empty($predictions) ? array(array('id' => '-1', 'label' => __('Add new place : ' . $input))) : $predictions;
	}

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
			/* Check if city name is found in description TODO: regexp */
			if(stripos($prediction->description, $cityName) !== false) {
				$restrictedPredictions[] = array(
							'id' => $prediction->id . '|' . $prediction->reference,
							'label' => $prediction->description
						);	
			}
			/*foreach($placeDetail->address_components as $addressComponent) {
				$longName = $addressComponent->long_name;
				if($addressComponent->long_name == $cityName) {
					if(array_search('locality', $addressComponent->types) !== false)
						$restrictedPredictions[] = array(
							'id' => $prediction->id,
							'label' => $prediction->description
						);	
				}
			}*/
		}
		//$restrictedPredictions = $predictions;
		return ($force === false) ? (empty($restrictedPredictions) ? array('id' => '-1', 'label' => __('No results for ' . $input)) : $restrictedPredictions) : $predictions;
	}

}
