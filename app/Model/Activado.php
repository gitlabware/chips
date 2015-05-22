<?php
App::uses('AppModel', 'Model');
/**
 * Activado Model
 *
 * @property Excel $Excel
 */
class Activado extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Excel' => array(
			'className' => 'Excel',
			'foreignKey' => 'excel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
