<?php
App::uses('AppModel', 'Model');
/**
 * Movimientospremio Model
 *
 * @property Premio $Premio
 * @property User $User
 * @property Persona $Persona
 */
class Movimientospremio extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Premio' => array(
			'className' => 'Premio',
			'foreignKey' => 'premio_id',
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
		),
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
