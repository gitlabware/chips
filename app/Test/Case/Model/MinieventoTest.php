<?php
App::uses('Minievento', 'Model');

/**
 * Minievento Test Case
 *
 */
class MinieventoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.minievento'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Minievento = ClassRegistry::init('Minievento');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Minievento);

		parent::tearDown();
	}

}
