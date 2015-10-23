<?php
App::uses('AppModel', 'Model');
/**
 * Pago Model
 *
 * @property Ventascelulare $Ventascelulare
 */

class Pago extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ventascelulare' => array(
			'className' => 'Ventascelulare',
			'foreignKey' => 'ventascelulare_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
