<?php
App::uses('AppModel', 'Model');
/**
 * Pedido Model
 *
 * @property User $User
 * @property Producto $Producto
 * @property Distribuidor $Distribuidor
 */
class Pedido extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		'Distribuidor' => array(
			'className' => 'User',
			'foreignKey' => 'distribuidor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
