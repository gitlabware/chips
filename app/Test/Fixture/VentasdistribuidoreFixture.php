<?php
/**
 * VentasdistribuidoreFixture
 *
 */
class VentasdistribuidoreFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 7),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'persona_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'cliente_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'cantidad' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'escala' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'precio' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'total' => array('type' => 'integer', 'null' => true, 'default' => null),
		'fecha' => array('type' => 'date', 'null' => false, 'default' => null),
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
			'producto_id' => 1,
			'user_id' => 1,
			'persona_id' => 1,
			'cliente_id' => 1,
			'cantidad' => 1,
			'escala' => 'Lorem ipsum dolor ',
			'precio' => 1,
			'total' => 1,
			'fecha' => '2013-04-17'
		),
	);

}
