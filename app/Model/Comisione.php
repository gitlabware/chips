<?php
App::uses('AppModel', 'Model');
/**
 * Comisione Model
 *
 * @property Cliente $Cliente
 * @property Excel $Excel
 */
class Comisione extends AppModel {


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
		'Excel' => array(
			'className' => 'Excel',
			'foreignKey' => 'excel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
