<?php
App::uses('Recargascabina', 'Model');

/**
 * Recargascabina Test Case
 *
 */
class RecargascabinaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.recargascabina',
		'app.producto',
		'app.tiposproducto',
		'app.productosprecio',
		'app.tipousuario'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Recargascabina = ClassRegistry::init('Recargascabina');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Recargascabina);

		parent::tearDown();
	}

}
