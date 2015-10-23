<?php
App::uses('AppModel', 'Model');
/**
 * Ventascliente Model
 *
 * @property Cliente $Cliente
 * @property Ventasdistribuidore $Ventasdistribuidore
 */
class Ventascliente extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = '45';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Ventasdistribuidore' => array(
			'className' => 'Ventasdistribuidore',
			'foreignKey' => 'ventasdistribuidore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
