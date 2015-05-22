<?php
/**
 * DepositoFixture
 *
 */
class DepositoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'banco' => array('type' => 'integer', 'null' => true, 'default' => null),
		'efectivo' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'integer', 'null' => true, 'default' => null),
		'persona_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'banco' => 1,
			'efectivo' => 1,
			'created' => 1,
			'modified' => 1,
			'persona_id' => 1
		),
	);

}
