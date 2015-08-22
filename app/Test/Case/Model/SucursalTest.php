<?php
App::uses('Sucursal', 'Model');

/**
 * Sucursal Test Case
 *
 */
class SucursalTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sucursal',
		'app.almacene',
		'app.persona',
		'app.detalle',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.tipousuario',
		'app.movimiento',
		'app.user',
		'app.group',
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
		$this->Sucursal = ClassRegistry::init('Sucursal');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sucursal);

		parent::tearDown();
	}

}
