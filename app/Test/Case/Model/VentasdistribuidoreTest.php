<?php
App::uses('Ventasdistribuidore', 'Model');

/**
 * Ventasdistribuidore Test Case
 *
 */
class VentasdistribuidoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ventasdistribuidore',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.user',
		'app.group',
		'app.persona',
		'app.cliente'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ventasdistribuidore = ClassRegistry::init('Ventasdistribuidore');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ventasdistribuidore);

		parent::tearDown();
	}

}
