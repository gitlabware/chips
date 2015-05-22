<?php
/**
 * RecargascabinaFixture
 *
 */
class RecargascabinaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'producto_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'monto' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'monto_recarga' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'created' => array('type' => 'date', 'null' => true, 'default' => null),
		'modified' => array('type' => 'date', 'null' => true, 'default' => null),
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
			'producto_id' => 1,
			'monto' => 1,
			'monto_recarga' => 1,
			'created' => '2013-06-02',
			'modified' => '2013-06-02'
		),
	);

}
