<?php
App::uses('Ventascliente', 'Model');

/**
 * Ventascliente Test Case
 *
 */
class VentasclienteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ventascliente',
		'app.cliente',
		'app.lugare',
		'app.user',
		'app.group',
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.deposito',
		'app.banco',
		'app.detalle',
		'app.producto',
		'app.tiposproducto',
		'app.marca',
		'app.colore',
		'app.productosprecio',
		'app.tipousuario',
		'app.movimiento',
		'app.recarga',
		'app.porcentaje',
		'app.ventascelulare',
		'app.ventasdistribuidore',
		'app.movimientoscabina',
		'app.movimientosrecarga',
		'app.rutasusuario',
		'app.ruta'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ventascliente = ClassRegistry::init('Ventascliente');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ventascliente);

		parent::tearDown();
	}

}
