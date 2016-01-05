<?php
App::uses('AppModel', 'Model');
/**
 * Distribuidorpago Model
 *
 * @property Distribuidor $Distribuidor
 */
class Distribuidorpago extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Distribuidor' => array(
			'className' => 'User',
			'foreignKey' => 'distribuidor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
