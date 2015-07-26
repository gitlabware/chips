<?php
App::uses('AppModel', 'Model');
/**
 * Ventasdistribuidore Model
 *
 * @property Persona $Persona
 */
class Ventasdistribuidore extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
