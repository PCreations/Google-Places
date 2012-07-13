<?php
/**
 * LocalizedFixture
 *
 */
class LocalizedFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'localized';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'place_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE_LOCALIZING' => array('column' => array('model', 'foreign_key'), 'unique' => 1), 'INDEX_LOCALIZED' => array('column' => 'model', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'foreign_key' => 1,
			'place_id' => 'Lorem ipsum dolor sit amet',
			'model' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-07-13 09:09:05',
			'modified' => '2012-07-13 09:09:05'
		),
	);
}
