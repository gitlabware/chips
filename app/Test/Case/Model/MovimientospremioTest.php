<?php
App::uses('Movimientospremio', 'Model');

/**
 * Movimientospremio Test Case
 *
 */
class MovimientospremioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.movimientospremio',
		'app.premio',
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
		'app.cliente',
		'app.lugare',
		'app.rutasusuarios',
		'app.recarga',
		'app.porcentaje',
		'app.recargado',
		'app.ventasdistribuidore',
		'app.ventascelulare',
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
		$this->Movimientospremio = ClassRegistry::init('Movimientospremio');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Movimientospremio);

		parent::tearDown();
	}

}
