<?php
App::uses('Ventascelulare', 'Model');

/**
 * Ventascelulare Test Case
 *
 */
class VentascelulareTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ventascelulare',
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
		'app.cliente',
		'app.lugare',
		'app.ruta',
		'app.recarga',
		'app.ventasdistribuidore'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ventascelulare = ClassRegistry::init('Ventascelulare');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ventascelulare);

		parent::tearDown();
	}

}
