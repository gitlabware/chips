<?php
App::uses('Recargado', 'Model');

/**
 * Recargado Test Case
 *
 */
class RecargadoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.recargado',
		'app.user',
		'app.group',
		'app.persona',
		'app.sucursal',
		'app.almacene',
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
		'app.porcentaje',
		'app.ventasdistribuidore',
		'app.encargado'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Recargado = ClassRegistry::init('Recargado');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Recargado);

		parent::tearDown();
	}

}
