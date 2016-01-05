<?php

App::uses('AppModel', 'Model');

/**
 * Banco Model
 *
 * @property Deposito $Deposito
 */
class Banco extends AppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * hasMany associations
   *
   * @var array
   */
  public $belongsTo = array(
    'Sucursal' => array(
      'className' => 'Sucursal',
      'foreignKey' => 'sucursal_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    )
  );
  /*public $hasMany = array(
    'Deposito' => array(
      'className' => 'Deposito',
      'foreignKey' => 'banco_id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    )
  );*/

}
