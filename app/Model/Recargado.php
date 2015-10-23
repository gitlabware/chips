<?php
App::uses('AppModel', 'Model');
/**
 * Recargado Model
 *
 * @property User $User
 * @property Encargado $Encargado
 * @property Persona $Persona
 * @property Porcentaje $Porcentaje
 */
class Recargado extends AppModel {


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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'encargado_id',
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
		),
		'Porcentaje' => array(
			'className' => 'Porcentaje',
			'foreignKey' => 'porcentaje_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
