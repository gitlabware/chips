<?php
/**
 * RecargaFixture
 *
 */
class RecargaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'cliente_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'persona_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'numero' => array('type' => 'integer', 'null' => true, 'default' => null),
		'monto' => array('type' => 'integer', 'null' => true, 'default' => null),
		'porcentaje' => array('type' => 'integer', 'null' => true, 'default' => null),
		'xcobrar' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1),
		'total' => array('type' => 'integer', 'null' => true, 'default' => null),
		'estado' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'comment' => '0 = por cargar, 1= realizado'),
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
			'cliente_id' => 1,
			'user_id' => 1,
			'persona_id' => 1,
			'numero' => 1,
			'monto' => 1,
			'porcentaje' => 1,
			'xcobrar' => 1,
			'total' => 1,
			'estado' => 1,
			'created' => '2013-04-20',
			'modified' => '2013-04-20'
		),
	);

}
