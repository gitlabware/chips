<?php
App::uses('AppModel', 'Model');
/**
 * Almacene Model
 *
 * @property Sucursal $Sucursal
 */
class Almacene extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Sucursal' => array(
			'className' => 'Sucursal',
			'foreignKey' => 'sucursal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
