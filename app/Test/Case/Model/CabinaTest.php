<?php
App::uses('Cabina', 'Model');

/**
 * Cabina Test Case
 *
 */
class CabinaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cabina',
		'app.sucursal',
		'app.almacene',
		'app.user',
		'app.group',
		'app.persona',
		'app.detalle',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.tipousuario',
		'app.movimiento',
		'app.recarga',
		'app.cliente',
		'app.ventasdistribuidore',
		'app.movimientoscabina'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cabina = ClassRegistry::init('Cabina');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cabina);

		parent::tearDown();
	}

}
