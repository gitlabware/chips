<?php
/**
 * MovimientospremioFixture
 *
 */
class MovimientospremioFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'premio_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'ingreso' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false),
		'salida' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'persona_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'premio_id' => 1,
			'ingreso' => 1,
			'salida' => 1,
			'user_id' => 1,
			'persona_id' => 1,
			'created' => '2015-06-18 17:52:44',
			'modified' => '2015-06-18 17:52:44'
		),
	);

}
