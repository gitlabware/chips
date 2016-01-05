<?php
/**
 * DistribuidorpagoFixture
 *
 */
class DistribuidorpagoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'distribuidor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'faltante' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'otro_ingreso' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'total' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'observaciones' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha' => array('type' => 'date', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'distribuidor_id' => 1,
			'faltante' => '',
			'otro_ingreso' => '',
			'total' => '',
			'observaciones' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'fecha' => '2015-12-31',
			'created' => '2015-12-31 16:33:48',
			'modified' => '2015-12-31 16:33:48'
		),
	);

}
