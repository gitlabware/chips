<?php
App::uses('Distribucione', 'Model');

/**
 * Distribucione Test Case
 *
 */
class DistribucioneTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.distribucione',
		'app.almacene',
		'app.sucursal',
		'app.user',
		'app.group',
		'app.persona',
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
		'app.ruta',
		'app.rutasusuario',
		'app.recarga',
		'app.porcentaje',
		'app.ventascelulare',
		'app.ventasdistribuidore',
		'app.movimientoscabina',
		'app.movimientosrecarga',
		'app.excel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Distribucione = ClassRegistry::init('Distribucione');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Distribucione);

		parent::tearDown();
	}

}
