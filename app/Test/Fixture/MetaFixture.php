<?php
/**
 * MetaFixture
 *
 */
class MetaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'ruta_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'mes' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'unsigned' => false),
		'anyo' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'unsigned' => false),
		'meta' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
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
			'ruta_id' => 1,
			'mes' => 1,
			'anyo' => 1,
			'meta' => 1,
			'created' => '2016-03-02 20:20:10',
			'modified' => '2016-03-02 20:20:10'
		),
	);

}
