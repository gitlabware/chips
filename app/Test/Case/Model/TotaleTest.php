<?php
App::uses('Totale', 'Model');

/**
 * Totale Test Case
 *
 */
class TotaleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.totale',
		'app.producto',
		'app.tiposproducto',
		'app.marca',
		'app.colore',
		'app.productosprecio',
		'app.tipousuario',
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.user',
		'app.group',
		'app.lugare',
		'app.cliente',
		'app.rutasusuarios',
		'app.recarga',
		'app.porcentaje',
		'app.recargado',
		'app.ventasdistribuidore',
		'app.deposito',
		'app.banco',
		'app.movimiento',
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
		$this->Totale = ClassRegistry::init('Totale');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Totale);

		parent::tearDown();
	}

}
