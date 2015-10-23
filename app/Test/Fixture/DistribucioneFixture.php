<?php
/**
 * DistribucioneFixture
 *
 */
class DistribucioneFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'almacene_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'sucursal_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'cantidad' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'excel_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'estado' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'almacene_id' => 1,
			'sucursal_id' => 1,
			'producto_id' => 1,
			'cantidad' => 1,
			'excel_id' => 1,
			'estado' => 'Lorem ipsum dolor sit amet',
			'created' => '2015-08-20 16:07:26',
			'modified' => '2015-08-20 16:07:26'
		),
	);

}
