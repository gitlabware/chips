<?php
App::uses('Comisione', 'Model');

/**
 * Comisione Test Case
 *
 */
class ComisioneTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.comisione',
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
		'app.ruta',
		'app.excel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Comisione = ClassRegistry::init('Comisione');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comisione);

		parent::tearDown();
	}

}
