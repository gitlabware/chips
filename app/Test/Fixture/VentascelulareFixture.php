<?php
/**
 * VentascelulareFixture
 *
 */
class VentascelulareFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'entrada' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'salida' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'total' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'imei' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'num_serie' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tipo_cambio' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '15,2', 'unsigned' => false),
		'precio' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'cliente' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'observaciones' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
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
			'user_id' => 1,
			'producto_id' => 1,
			'entrada' => 1,
			'salida' => 1,
			'total' => 1,
			'imei' => 'Lorem ipsum dolor sit amet',
			'num_serie' => 'Lorem ipsum dolor sit amet',
			'tipo_cambio' => '',
			'precio' => 1,
			'cliente' => 'Lorem ipsum dolor sit amet',
			'observaciones' => 'Lorem ipsum dolor sit amet',
			'created' => '2015-05-09 10:03:59',
			'modified' => '2015-05-09 10:03:59'
		),
	);

}
