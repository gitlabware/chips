<?php
App::uses('Persona', 'Model');

/**
 * Persona Test Case
 *
 */
class PersonaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.user',
		'app.group',
		'app.lugare',
		'app.cliente',
		'app.ruta',
		'app.recarga',
		'app.porcentaje',
		'app.ventasdistribuidore',
		'app.producto',
		'app.tiposproducto',
		'app.marca',
		'app.productosprecio',
		'app.tipousuario',
		'app.deposito',
		'app.banco',
		'app.movimiento',
		'app.movimientoscabina',
		'app.movimientosrecarga',
		'app.recargado',
		'app.encargado',
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
		$this->Persona = ClassRegistry::init('Persona');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Persona);

		parent::tearDown();
	}

}
