<?php
App::uses('Deposito', 'Model');

/**
 * Deposito Test Case
 *
 */
class DepositoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.deposito',
		'app.user',
		'app.group',
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.detalle',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.tipousuario',
		'app.movimiento',
		'app.recarga',
		'app.cliente',
		'app.ventasdistribuidore'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Deposito = ClassRegistry::init('Deposito');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Deposito);

		parent::tearDown();
	}

}
