<?php
/**
 * TotaleFixture
 *
 */
class TotaleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'producto_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'persona_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'almacene_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'total' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modififed' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'producto_id' => 1,
			'persona_id' => 1,
			'almacene_id' => 1,
			'total' => 1,
			'created' => '2015-06-12 18:07:16',
			'modififed' => '2015-06-12 18:07:16'
		),
	);

}
