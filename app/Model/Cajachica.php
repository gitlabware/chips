<?php
App::uses('AppModel', 'Model');
/**
 * Cajachica Model
 *
 * @property Cajadetalle $Cajadetalle
 * @property User $User
 */
class Cajachica extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cajadetalle' => array(
			'className' => 'Cajadetalle',
			'foreignKey' => 'cajadetalle_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
