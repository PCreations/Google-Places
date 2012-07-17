<?php
App::uses('GooglePlacesAppModel', 'GooglePlaces.Model');
/**
 * Localized Model
 *
 * @property Place $Place
 */
class Localized extends GooglePlacesAppModel {

	public $actsAs = array('Containable');

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'localized';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'place_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Place not valid, dont forget to select a place within list',
				'allowEmpty' => false,
				'required' => true,
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
		'Place' => array(
			'className' => 'GooglePlaces.Place',
			'foreignKey' => 'place_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'GooglePlaces.Country',
			'foreignKey' => 'foreign_key',
		)
	);

}
