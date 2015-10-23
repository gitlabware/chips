<?php
/**
 * VentasclienteFixture
 *
 */
class VentasclienteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'cliente_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'ventasdistribuidore_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'estado_pdv' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'cap' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'recarga' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => false),
		'n_recarga' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'linea_abonable' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			
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
			'cliente_id' => 1,
			'ventasdistribuidore_id' => 1,
			'estado_pdv' => 1,
			'cap' => 1,
			'recarga' => 1,
			'n_recarga' => 'Lorem ip',
			'linea_abonable' => 'Lorem ip',
			'created' => '2015-07-24 18:24:41',
			'modified' => '2015-07-24 18:24:41'
		),
	);

}
