<?php
App::uses('Ventastienda', 'Model');

/**
 * Ventastienda Test Case
 *
 */
class VentastiendaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ventastienda',
		'app.cliente',
		'app.recarga',
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
		'app.ventasdistribuidore'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ventastienda = ClassRegistry::init('Ventastienda');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ventastienda);

		parent::tearDown();
	}

}
