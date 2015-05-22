<?php
/**
 * ActivadoFixture
 *
 */
class ActivadoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 12, 'unsigned' => false),
		'dealer_code' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 12, 'unsigned' => false),
		'dealer' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dealer_nom_act' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 110, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subdealer_code' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 12, 'unsigned' => false),
		'subdealer' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subdealer_nom_act' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'canal_m' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'canal_n' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'ciudad_nro_tel' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha_act' => array('type' => 'date', 'null' => false, 'default' => null),
		'fehca_doc' => array('type' => 'date', 'null' => false, 'default' => null),
		'plan_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'excel_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'description' => 'Lorem ipsum dolor sit amet',
			'phone_number' => 1,
			'dealer_code' => 1,
			'dealer' => 'Lorem ipsum dolor sit amet',
			'dealer_nom_act' => 'Lorem ipsum dolor sit amet',
			'subdealer_code' => 1,
			'subdealer' => 'Lorem ipsum dolor sit amet',
			'subdealer_nom_act' => 'Lorem ipsum dolor sit amet',
			'canal_m' => 'Lorem ipsum dolor sit amet',
			'canal_n' => 'Lorem ipsum dolor sit amet',
			'created' => '2015-04-28',
			'ciudad_nro_tel' => 'Lorem ipsum dolor sit amet',
			'fecha_act' => '2015-04-28',
			'fehca_doc' => '2015-04-28',
			'plan_code' => 'Lorem ipsum dolor sit amet',
			'excel_id' => 1
		),
	);

}
