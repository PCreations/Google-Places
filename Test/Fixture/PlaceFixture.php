<?php
/**
 * PlaceFixture
 *
 */
class PlaceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'reference' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'formatted_address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'formatted_phone_number' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'latitude' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'longitude' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'rating' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'country_id' => array('column' => 'country_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'Lorem ipsum dolor sit amet',
			'country_id' => 1,
			'reference' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'formatted_address' => 'Lorem ipsum dolor sit amet',
			'formatted_phone_number' => 'Lorem ipsum dolor sit amet',
			'latitude' => 1,
			'longitude' => 1,
			'rating' => 1
		),
	);
}
