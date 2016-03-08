<?php
App::uses('Celcambio', 'Model');

/**
 * Celcambio Test Case
 *
 */
class CelcambioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.celcambio',
		'app.producto',
		'app.tiposproducto',
		'app.marca',
		'app.colore',
		'app.productosprecio',
		'app.tipousuario',
		'app.ventascelulare',
		'app.user',
		'app.group',
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.deposito',
		'app.banco',
		'app.detalle',
		'app.movimiento',
		'app.cliente',
		'app.lugare',
		'app.ruta',
		'app.rutasusuario',
		'app.recarga',
		'app.porcentaje',
		'app.ventasdistribuidore',
		'app.movimientoscabina',
		'app.movimientosrecarga'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Celcambio = ClassRegistry::init('Celcambio');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Celcambio);

		parent::tearDown();
	}

}
