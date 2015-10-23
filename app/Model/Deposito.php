<?php
App::uses('AppModel', 'Model');
/**
 * Deposito Model
 *
 * @property User $User
 * @property Persona $Persona
 */
class Deposito extends AppModel {


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
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Banco'=>array(
                    'className' =>'Banco',
                    'foreignKey'=> 'banco_id',
                    'conditions'=>'',
                    'fields'=>'',
                    'order'=>''
                )
	);
}
