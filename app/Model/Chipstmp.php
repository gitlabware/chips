<?php
App::uses('AppModel', 'Model');
/**
 * Chipstmp Model
 *
 * @property Excel $Excel
 */
class Chipstmp extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chipstmp';


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
