<?php
App::uses('AppModel', 'Model');
/**
 * Ventasproducto Model
 *
 * @property Ventasdistribuidore $Ventasdistribuidore
 * @property Producto $Producto
 * @property Cliente $Cliente
 */
class Ventasproducto extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ventasdistribuidore' => array(
			'className' => 'Ventasdistribuidore',
			'foreignKey' => 'ventasdistribuidore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Producto' => array(
			'className' => 'Producto',
			'foreignKey' => 'producto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
