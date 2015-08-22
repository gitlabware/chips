<?php

App::uses('AppModel', 'Model');

/**
 * Cliente Model
 *
 * @property Ruta $Ruta
 * @property Recarga $Recarga
 * @property Ventasdistribuidore $Ventasdistribuidore
 */
class Cliente extends AppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  /* public $belongsTo = array(
    'Ruta' => array(
    'className' => 'Ruta',
    'foreignKey' => 'ruta_id',
    'conditions' => '',
    'fields' => '',
    'order' => ''
    )
    ); */



  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'Lugare' => array(
      'className' => 'Lugare',
      'foreignKey' => 'lugare_id',
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

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'Recarga' => array(
      'className' => 'Recarga',
      'foreignKey' => 'cliente_id',
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
