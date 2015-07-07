<?php
App::uses('Precio', 'Model');

/**
 * Precio Test Case
 *
 */
class PrecioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.precio'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Precio = ClassRegistry::init('Precio');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Precio);

		parent::tearDown();
	}

}
