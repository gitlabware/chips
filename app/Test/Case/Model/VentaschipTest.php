<?php
App::uses('Ventaschip', 'Model');

/**
 * Ventaschip Test Case
 *
 */
class VentaschipTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ventaschip',
		'app.distribuidor'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ventaschip = ClassRegistry::init('Ventaschip');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ventaschip);

		parent::tearDown();
	}

}
