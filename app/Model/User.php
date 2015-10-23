<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Persona $Persona
 * @property Sucursal $Sucursal
 * @property Lugare $Lugare
 * @property Ruta $Ruta
 * @property Deposito $Deposito
 * @property Movimiento $Movimiento
 * @property Movimientoscabina $Movimientoscabina
 * @property Movimientosrecarga $Movimientosrecarga
 * @property Recargado $Recargado
 * @property Recarga $Recarga
 * @property Ventascelulare $Ventascelulare
 * @property Ventasdistribuidore $Ventasdistribuidore
 */
class User extends AppModel {
  
  
  public $validate = array(
        'username' => array(
            'limitDuplicateusername' => array(
                'rule' => array('limitDuplicateusername', 1),
                'message' => 'El usuario ya fue registrado'
            )
        )
    );
    
    public function limitDuplicateusername($check, $limit) {
        // $check will have value: array('promotion_code' => 'some-value')
        // $limit will have value: 25
        if(!empty($check['username']))
        {
            if(!empty($this->data['User']['id']))
            {
                $check['User.id !='] = $this->data['User']['id'];
            }
            if(!empty($this->getID())){
              $check['User.id !='] = $this->getID();
            }
            $existingPromoCount = $this->find('count', array(
                'conditions' => $check,
                'recursive' => -1
            ));
            return $existingPromoCount < $limit;
        }
        else{
            return TRUE;
        }
        
    }


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
		),
		'Sucursal' => array(
			'className' => 'Sucursal',
			'foreignKey' => 'sucursal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Lugare' => array(
			'className' => 'Lugare',
			'foreignKey' => 'lugare_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		/*'Ruta' => array(
			'className' => 'Ruta',
			'foreignKey' => 'ruta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Deposito' => array(
			'className' => 'Deposito',
			'foreignKey' => 'user_id',
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
		'Movimiento' => array(
			'className' => 'Movimiento',
			'foreignKey' => 'user_id',
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
		'Movimientoscabina' => array(
			'className' => 'Movimientoscabina',
			'foreignKey' => 'user_id',
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
		'Movimientosrecarga' => array(
			'className' => 'Movimientosrecarga',
			'foreignKey' => 'user_id',
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
		'Recarga' => array(
			'className' => 'Recarga',
			'foreignKey' => 'user_id',
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
		'Ventascelulare' => array(
			'className' => 'Ventascelulare',
			'foreignKey' => 'user_id',
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
      'foreignKey' => 'user_id',
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
  
  public function beforeSave($options = array())
    {
      if (!empty($this->data['User']['password'])) {
      $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
    }
    return true;
    }

}
