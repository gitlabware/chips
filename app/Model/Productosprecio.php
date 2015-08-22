<?php
App::uses('AppModel', 'Model');
/**
 * Productosprecio Model
 *
 * @property Producto $Producto
 * @property Tipousuario $Tipousuario
 */
class Productosprecio extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Producto' => array(
			'className' => 'Producto',
			'foreignKey' => 'producto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tipousuario' => array(
			'className' => 'Tipousuario',
			'foreignKey' => 'tipousuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
