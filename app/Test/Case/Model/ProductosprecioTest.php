<?php
App::uses('Productosprecio', 'Model');

/**
 * Productosprecio Test Case
 *
 */
class ProductosprecioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.productosprecio',
		'app.producto',
		'app.tiposproducto'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Productosprecio = ClassRegistry::init('Productosprecio');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Productosprecio);

		parent::tearDown();
	}

}
