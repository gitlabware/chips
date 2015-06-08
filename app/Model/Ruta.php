<?php

App::uses('AppModel', 'Model');

/**
 * Ruta Model
 *
 * @property Cliente $Cliente
 */
class Ruta extends AppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'Cliente' => array(
      'className' => 'Cliente',
      'foreignKey' => 'ruta_id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    ),
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'ruta_id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    ),    
    'Rutasusuario' => array(
      'className' => 'Rutasusuario',
      'foreignKey' => 'ruta_id',
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
  );

}
