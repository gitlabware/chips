<?php
App::uses('AppModel', 'Model');
/**
 * Recarga Model
 *
 * @property Cliente $Cliente
 * @property User $User
 * @property Persona $Persona
 */
class Recarga extends AppModel {


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
		),
                'Porcentaje' => array(
                        'className' => 'Porcentaje',
                        'foreignKey' => 'porcentaje_id',
                        'conditions' =>'',
                        'fields' => '',
                        'order' =>''
                )
	);
}
