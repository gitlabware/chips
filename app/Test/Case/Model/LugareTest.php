<?php
App::uses('Lugare', 'Model');

/**
 * Lugare Test Case
 *
 */
class LugareTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lugare',
		'app.cliente',
		'app.recarga',
		'app.user',
		'app.group',
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.detalle',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.tipousuario',
		'app.movimiento',
		'app.ventasdistribuidore'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lugare = ClassRegistry::init('Lugare');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lugare);

		parent::tearDown();
	}

}
