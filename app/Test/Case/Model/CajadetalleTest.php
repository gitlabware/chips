<?php
App::uses('Cajadetalle', 'Model');

/**
 * Cajadetalle Test Case
 *
 */
class CajadetalleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cajadetalle'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cajadetalle = ClassRegistry::init('Cajadetalle');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cajadetalle);

		parent::tearDown();
	}

}
