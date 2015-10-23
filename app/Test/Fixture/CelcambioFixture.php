<?php
/**
 * CelcambioFixture
 *
 */
class CelcambioFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'imei_anterior' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'imei_nuevo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'num_serie_anterior' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'num_serie_nuevo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ventascelulare_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'sucursal_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'producto_id' => 1,
			'imei_anterior' => 'Lorem ipsum dolor sit amet',
			'imei_nuevo' => 'Lorem ipsum dolor sit amet',
			'num_serie_anterior' => 'Lorem ipsum dolor sit amet',
			'num_serie_nuevo' => 'Lorem ipsum dolor sit amet',
			'ventascelulare_id' => 1,
			'sucursal_id' => 1,
			'created' => '2015-10-23 15:37:02',
			'modified' => '2015-10-23 15:37:02'
		),
	);

}
