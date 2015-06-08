<?php
App::uses('AppModel', 'Model');
/**
 * Rutasusuario Model
 *
 * @property User $User
 * @property Ruta $Ruta
 */
class Rutasusuario extends AppModel {


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
		'Ruta' => array(
			'className' => 'Ruta',
			'foreignKey' => 'ruta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
