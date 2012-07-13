<?php
App::uses('GooglePlacesAppModel', 'GooglePlaces.Model');
/**
 * PlaceTypesPlace Model
 *
 * @property PlaceType $PlaceType
 * @property Place $Place
 */
class PlaceTypesPlace extends GooglePlacesAppModel {

	public $actsAs = array('Containable');
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'place_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'place_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PlaceType' => array(
			'className' => 'GooglePlaces.PlaceType',
			'foreignKey' => 'place_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true
		),
		'Place' => array(
			'className' => 'GooglePlaces.Place',
			'foreignKey' => 'place_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true
		)
	);
}
