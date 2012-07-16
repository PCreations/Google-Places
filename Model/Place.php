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

	public $actsAs = array('Containable');

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
