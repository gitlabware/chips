<?php
App::uses('Recarga', 'Model');

/**
 * Recarga Test Case
 *
 */
class RecargaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.recarga',
		'app.cliente',
		'app.ventasdistribuidore',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.tipousuario',
		'app.user',
		'app.group',
		'app.persona',
		'app.sucursal',
		'app.almacene',
		'app.movimiento'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Recarga = ClassRegistry::init('Recarga');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Recarga);

		parent::tearDown();
	}

}
