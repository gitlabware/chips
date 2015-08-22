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
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.user',
		'app.group',
		'app.lugare',
		'app.cliente',
		'app.ruta',
		'app.rutasusuario',
		'app.recarga',
		'app.porcentaje',
		'app.deposito',
		'app.banco',
		'app.movimiento',
		'app.producto',
		'app.tiposproducto',
		'app.marca',
		'app.colore',
		'app.productosprecio',
		'app.tipousuario',
		'app.movimientoscabina',
		'app.movimientosrecarga',
		'app.ventascelulare',
		'app.detalle'
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
