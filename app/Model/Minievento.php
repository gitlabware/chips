<?php

App::uses('AppModel', 'Model');

/**
 * Minievento Model
 *
 */
class Minievento extends AppModel {

  public $belongsTo = array(
    'Impulsador' => array(
      'className' => 'User',
      'foreignKey' => 'impulsador_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    )
  );

}
