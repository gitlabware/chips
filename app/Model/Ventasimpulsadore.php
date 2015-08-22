<?php

App::uses('AppModel', 'Model');

/**
 * Ventasimpulsadore Model
 *
 * @property Minievento $Minievento
 */
class Ventasimpulsadore extends AppModel {
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'Minievento' => array(
      'className' => 'Minievento',
      'foreignKey' => 'minievento_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ),
    'Premio' => array(
      'className' => 'Premio',
      'foreignKey' => 'premio_id',
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
    )
  );

}
