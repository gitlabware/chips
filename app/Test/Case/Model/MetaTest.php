<?php
App::uses('Meta', 'Model');

/**
 * Meta Test Case
 *
 */
class MetaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.meta',
		'app.ruta',
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
		'app.rutasusuario'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Meta = ClassRegistry::init('Meta');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Meta);

		parent::tearDown();
	}

}
