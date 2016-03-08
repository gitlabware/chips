<?php
App::uses('AppModel', 'Model');
/**
 * Celcambio Model
 *
 * @property Producto $Producto
 * @property Ventascelulare $Ventascelulare
 * @property Sucursal $Sucursal
 */
class Celcambio extends AppModel {


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
		'Ventascelulare' => array(
			'className' => 'Ventascelulare',
			'foreignKey' => 'ventascelulare_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sucursal' => array(
			'className' => 'Sucursal',
			'foreignKey' => 'sucursal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
