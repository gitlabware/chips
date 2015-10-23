<?php
App::uses('Ventasimpulsadore', 'Model');

/**
 * Ventasimpulsadore Test Case
 *
 */
class VentasimpulsadoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ventasimpulsadore',
		'app.minievento'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ventasimpulsadore = ClassRegistry::init('Ventasimpulsadore');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ventasimpulsadore);

		parent::tearDown();
	}

}
