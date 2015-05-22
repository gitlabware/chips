<?php
App::uses('Activado', 'Model');

/**
 * Activado Test Case
 *
 */
class ActivadoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.activado'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Activado = ClassRegistry::init('Activado');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Activado);

		parent::tearDown();
	}

}
