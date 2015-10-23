<?php
/**
 * ProductoFixture
 *
 */
class ProductoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 7, 'key' => 'primary'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'precio_compra' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'proveedor' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha_ingreso' => array('type' => 'date', 'null' => false, 'default' => null),
		'tipousuario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 7),
		'tipo_producto' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tiposproducto_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'observaciones' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'estado' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
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
			'nombre' => 'Lorem ipsum dolor sit amet',
			'precio_compra' => 1,
			'proveedor' => 'Lorem ipsum dolor sit amet',
			'fecha_ingreso' => '2013-04-09',
			'tipousuario_id' => 1,
			'tipo_producto' => 'Lorem ipsum dolor sit amet',
			'tiposproducto_id' => 1,
			'observaciones' => 'Lorem ipsum dolor sit amet',
			'estado' => 1
		),
	);

}
