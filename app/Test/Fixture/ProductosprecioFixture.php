<?php
/**
 * ProductosprecioFixture
 *
 */
class ProductosprecioFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 7),
		'min' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'max' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'escala' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tipousuario_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'precio' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
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
			'min' => 1,
			'max' => 1,
			'escala' => 'Lorem ipsum dolor ',
			'tipousuario_id' => 1,
			'precio' => 1,
			'fecha' => '2013-04-09'
		),
	);

}
