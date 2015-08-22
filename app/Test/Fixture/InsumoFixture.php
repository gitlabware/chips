<?php
/**
 * InsumoFixture
 *
 */
class InsumoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'preciocompra' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '15,2'),
		'precioventa' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '15,2'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'categoria_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'unidade_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'marca' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'codigo_barra' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha_vencimiento' => array('type' => 'date', 'null' => true, 'default' => null),
		'estado' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
		'observaciones' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'preciocompra' => 1,
			'precioventa' => 1,
			'created' => '2013-01-18 13:17:32',
			'categoria_id' => 1,
			'unidade_id' => 1,
			'marca' => 'Lorem ipsum dolor sit amet',
			'codigo_barra' => 'Lorem ipsum dolor sit amet',
			'fecha_vencimiento' => '2013-01-18',
			'estado' => 1,
			'observaciones' => 'Lorem ipsum dolor sit amet'
		),
	);

}
