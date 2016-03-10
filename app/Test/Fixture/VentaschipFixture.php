<?php
/**
 * VentaschipFixture
 *
 */
class VentaschipFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'distribuidor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'cantidad' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'precio' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'fecha' => array('type' => 'date', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'distribuidor_id' => 1,
			'cantidad' => 1,
			'precio' => '',
			'fecha' => '2015-12-31',
			'created' => '2015-12-31 06:28:36',
			'modified' => '2015-12-31 06:28:36'
		),
	);

}
