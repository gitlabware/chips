<?php
App::uses('Distribuidorpago', 'Model');

/**
 * Distribuidorpago Test Case
 *
 */
class DistribuidorpagoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.distribuidorpago',
		'app.distribuidor'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Distribuidorpago = ClassRegistry::init('Distribuidorpago');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Distribuidorpago);

		parent::tearDown();
	}

}
