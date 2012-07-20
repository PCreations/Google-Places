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

	public function savePlace($place) {
		/* Check if place already exists in db */
		if($this->isAlreadyExists($place->id)) {
			/* Check for update id */
			$placeDetails = $this->GooglePlacesAPI->api->detail($place->reference);
			if($placeDetails->id != $place->id) {

				$place->id = $this->updatePlaceId($place->id, $placeDetails->id);
			}
		}
		else { /* Else add the place */
			$this->PlaceTypesPlace->savePlaceAndTypes($place);
		}
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

}
