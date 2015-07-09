<?php
App::uses('AppModel', 'Model');
/**
 * Porcentaje Model
 *
 * @property Recargado $Recargado
 * @property Recarga $Recarga
 */
class Porcentaje extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Recarga' => array(
			'className' => 'Recarga',
			'foreignKey' => 'porcentaje_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
