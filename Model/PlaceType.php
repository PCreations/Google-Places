<?php
App::uses('GooglePlacesAppModel', 'GooglePlaces.Model');
/**
 * PlaceType Model
 *
 * @property Place $Place
 */
class PlaceType extends GooglePlacesAppModel {

	public $actsAs = array('Containable');
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Place' => array(
			'className' => 'GooglePlaces.Place',
			'joinTable' => 'place_types_places',
			'with' => 'GooglePlaces.PlaceTypesPlace',
			'foreignKey' => 'place_type_id',
			'associationForeignKey' => 'place_id',
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

}
