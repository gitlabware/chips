<?php
App::uses('AppModel', 'Model');
/**
 * Ventascelulare Model
 *
 * @property User $User
 * @property Producto $Producto
 */
class Ventascelulare extends AppModel {


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
		'Almacene' => array(
			'className' => 'Almacene',
			'foreignKey' => 'almacene_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
