<?php
/**
 * VentastiendaFixture
 *
 */
class VentastiendaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'cliente_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 7),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'precio' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'escala' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'total' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'pedidotemporal' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'cantidad' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
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
			'cliente_id' => 1,
			'producto_id' => 1,
			'user_id' => 1,
			'precio' => 1,
			'escala' => 'Lorem ipsum dolor sit amet',
			'total' => 1,
			'pedidotemporal' => 1,
			'cantidad' => 1,
			'created' => '2013-04-29'
		),
	);

}
