<?php
App::uses('Porcentaje', 'Model');

/**
 * Porcentaje Test Case
 *
 */
class PorcentajeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.porcentaje',
		'app.recargado',
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
		'app.productosprecio',
		'app.tipousuario',
		'app.movimiento',
		'app.cliente',
		'app.lugare',
		'app.ruta',
		'app.recarga',
		'app.ventasdistribuidore',
		'app.ventascelulare',
		'app.movimientoscabina',
		'app.movimientosrecarga',
		'app.encargado'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Porcentaje = ClassRegistry::init('Porcentaje');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Porcentaje);

		parent::tearDown();
	}

}
