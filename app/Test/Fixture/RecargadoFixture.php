<?php
/**
 * RecargadoFixture
 *
 */
class RecargadoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'encargado_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'persona_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'porcentaje_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'entrada' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '15,2', 'unsigned' => false),
		'salida' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '15,2', 'unsigned' => false),
		'total' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '15,2', 'unsigned' => false),
		'num_celular' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'monto' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'observaciones' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'user_id' => 1,
			'encargado_id' => 1,
			'persona_id' => 1,
			'porcentaje_id' => 1,
			'entrada' => 1,
			'salida' => 1,
			'total' => 1,
			'num_celular' => 1,
			'monto' => '',
			'observaciones' => 'Lorem ipsum dolor sit amet',
			'created' => '2015-05-14 22:27:28',
			'modified' => '2015-05-14'
		),
	);

}
