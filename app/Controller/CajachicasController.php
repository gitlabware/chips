
<?php

App::uses('AppController', 'Controller');

/**
 * Almacenes Controller
 *
 * @property Almacene $Almacene
 */
class CajachicasController extends AppController {

  public $uses = array('Cajachica', 'Cajadetalle', 'Banco', 'Sucursal', 'Distribuidorpago', 'User');
  public $layout = 'viva';

  public function get_total($idBanco = null, $idSucursal = null) {
    /* $caja = $this->Cajachica->find('first', array(
      'recursive' => -1,
      'conditions' => array('Cajachica.sucursal_id' => $idSucursal),
      'order' => 'id DESC'
      )); */
    $caja = $this->Banco->find('first', array(
      'conditions' => array('Banco.sucursal_id' => $idSucursal, 'Banco.id' => $idBanco),
      'fields' => array('Banco.total')
    ));
    if (empty($caja)) {
      return 0.00;
    } else {
      return $caja['Banco']['total'];
    }
  }

  public function set_total($total = null, $idBanco = null, $idSucursal = null) {
    /* $caja = $this->Cajachica->find('first', array(
      'conditions' => array('Cajachica.sucursal_id' => $idSucursal),
      'recursive' => -1,
      'order' => 'id DESC'
      )); */
    $caja = $this->Banco->find('first', array(
      'conditions' => array('Banco.sucursal_id' => $idSucursal, 'Banco.id' => $idBanco),
      'fields' => array('Banco.id')
    ));
    if (!empty($caja)) {
      $this->Banco->id = $caja['Banco']['id'];
      $dcaja['total'] = $total;
      //$dcaja['user_id'] = $this->Session->read('Auth.User.id');
      $this->Banco->save($dcaja);
    } else {
      /* if ($total != 0) {
        $this->Banco->create();
        $dcaja['total'] = $total;
        $dcaja['user_id'] = $this->Session->read('Auth.User.id');
        $this->Banco->save($dcaja);
        } */
    }
  }

  public function index() {
    if ($this->request->data['Cajachica']) {
      $this->registra_caja();
    }
    if (empty($this->request->data['Dato']['fecha_ini'])) {
      $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
    }
    if (empty($this->request->data['Dato']['fecha_fin'])) {
      $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
    }
    if (!empty($this->request->data['Dato']['banco_id'])) {
      $condiciones['Cajachica.banco_id'] = $this->request->data['Dato']['banco_id'];
    }
    $condiciones['Cajachica.fecha >='] = $this->request->data['Dato']['fecha_ini'];
    $condiciones['Cajachica.fecha <='] = $this->request->data['Dato']['fecha_fin'];
    $condiciones['Cajachica.tipo'] = 'Ingreso';
    $cajachica_ing = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => $condiciones,
      'fields' => array('Cajachica.*', 'Cajadetalle.*','Banco.*')
    ));
    //debug($cajachica_ing);exit;
    $condiciones['Cajachica.tipo'] = 'Gasto';
    $cajachica_gas = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => $condiciones,
      'fields' => array('Cajachica.*', 'Cajadetalle.*')
    ));
    $this->Banco->virtualFields = array(
      'nombre_completo' => "CONCAT(Banco.nombre,' (',Banco.total,')')"
    );
    $idSucursal = $this->Session->read('Auth.User.sucursal_id');
    $bancos = $this->Banco->find('list', array(
      'conditions' => array('Banco.sucursal_id' => $idSucursal),
      'fields' => array('id', 'nombre_completo')
    ));
    $detalles = $this->Cajadetalle->find('list', array('conditions' => array('Cajadetalle.sucursal_id' => NULL), 'fields' => 'Cajadetalle.nombre'));
    //$sucursales = $this->Sucursal->find('list',array());
    $this->set(compact('cajachica_ing', 'cajachica_gas', 'detalles', 'bancos'));
  }

  public function registra_caja() {
    if (!empty($this->request->data['Cajadetalle']['nombre'])) {
      $this->Cajadetalle->create();
      $this->request->data['Cajadetalle']['sucursal_id'] = $this->Session->read('Auth.User.sucursal_id');
      $this->Cajadetalle->save($this->request->data['Cajadetalle']);
      $this->request->data['Cajachica']['cajadetalle_id'] = $this->Cajadetalle->getLastInsertID();
    }
    $dcaja = $this->request->data['Cajachica'];
    if (!empty($dcaja)) {
      $total = $this->get_total($this->request->data['Cajachica']['banco_id'], $this->request->data['Cajachica']['sucursal_id']);
      if ($dcaja['tipo'] == 'Gasto') {
        if ($dcaja['monto'] <= $total) {
          $this->Cajachica->create();
          $dcaja['total'] = $total - $dcaja['monto'];
          $this->Cajachica->save($dcaja);
          $this->Session->setFlash("Se registro correctamente en cajachica!!", 'msgbueno');
          $this->set_total($dcaja['total'], $dcaja['banco_id'], $dcaja['sucursal_id']);
          $this->redirect($this->referer());
        } else {
          $this->Session->setFlash("El gasto no debe exceder al total de $total", 'msgerror');
          $this->redirect($this->referer());
        }
      } else {
        $this->Cajachica->create();
        $dcaja['total'] = $total + $dcaja['monto'];
        $this->Cajachica->save($dcaja);
        $this->Session->setFlash("Se registro correctamente en cajachica!!", 'msgbueno');
        $this->set_total($dcaja['total'], $dcaja['banco_id'], $dcaja['sucursal_id']);
        $this->redirect($this->referer());
      }
    } else {
      $this->Session->setFlash("No se pudo registrar intente nuevamente!!", 'msgerror');
      $this->redirect($this->referer());
    }
  }

  public function elimina($idCaja = NULL) {
    $caja = $this->Cajachica->findByid($idCaja, null, null, -1);
    $idSucursal = $this->Session->read('Auth.User.sucursal_id');
    $total = $this->get_total($caja['Cajachica']['banco_id'], $idSucursal);
    if ($caja['Cajachica']['tipo'] == 'Ingreso') {
      if ($caja['Cajachica']['monto'] <= $total) {
        $this->Cajachica->delete($caja['Cajachica']['id']);
        $this->set_total(($total - $caja['Cajachica']['monto']), $caja['Cajachica']['banco_id'], $idSucursal);
        $this->Session->setFlash("Se elimino correctamente!!", 'msgbueno');
      } else {
        $this->Session->setFlash("El monto del ingreso no puede exceder al total de $total", 'msgerror');
      }
    } else {
      $this->Cajachica->delete($caja['Cajachica']['id']);
      $this->set_total(($total + $caja['Cajachica']['monto']), $caja['Cajachica']['banco_id'], $idSucursal);
      $this->Session->setFlash("Se elimino correctamente!!", 'msgbueno');
    }
    $this->redirect($this->referer());
  }

  public function micajachica() {
    $idSucursal = $this->Session->read('Auth.User.sucursal_id');
    $total = $this->get_total($idSucursal);
    if ($this->request->data['Cajachica']) {
      $this->registra_caja();
    }
    if (empty($this->request->data['Dato']['fecha_ini'])) {
      $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
    }
    if (empty($this->request->data['Dato']['fecha_fin'])) {
      $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
    }
    $this->Cajachica->virtualFields = array(
      'detalle_movimiento' => "CONCAT(Movimiento.salida,' - ',(SELECT productos.nombre FROM productos WHERE productos.id = Movimiento.producto_id))",
      'detalle_pago' => "CONCAT('Pago por equipo - ',(SELECT ventascelulares.cliente FROM ventascelulares WHERE ventascelulares.id = Pago.ventascelulare_id))"
    );
    $cajachica_ing = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Cajachica.sucursal_id' => $idSucursal,
        'Cajachica.fecha >=' => $this->request->data['Dato']['fecha_ini'],
        'Cajachica.fecha <=' => $this->request->data['Dato']['fecha_fin'],
        'Cajachica.tipo' => 'Ingreso'
      ),
      'fields' => array('Cajachica.*', 'Cajadetalle.*')
    ));
    //debug($cajachica_ing);exit;
    $cajachica_gas = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Cajachica.sucursal_id' => $idSucursal,
        'Cajachica.fecha >=' => $this->request->data['Dato']['fecha_ini'],
        'Cajachica.fecha <=' => $this->request->data['Dato']['fecha_fin'],
        'Cajachica.tipo' => 'Gasto'
      ),
      'fields' => array('Cajachica.*', 'Cajadetalle.*')
    ));
    //debug($idSucursal);exit;
    $this->Banco->virtualFields = array(
      'nombre_completo' => "CONCAT(Banco.nombre,' (',Banco.total,')')"
    );
    $bancos = $this->Banco->find('list', array(
      'conditions' => array('Banco.sucursal_id' => $idSucursal),
      'fields' => array('id', 'nombre_completo')
    ));
    $detalles = $this->Cajadetalle->find('list', array('conditions' => array('Cajadetalle.sucursal_id' => $idSucursal), 'fields' => 'Cajadetalle.nombre'));
    $this->set(compact('cajachica_ing', 'cajachica_gas', 'total', 'detalles', 'bancos'));
  }

  public function pago_dist($idDistribuidor = null, $total = 0.00, $fecha_ini = null, $idMiniEvento = NULL) {
    $this->layout = 'ajax';
    //debug($total);
    $idSucursal = $this->Session->read('Auth.User.sucursal_id');
    $bancos = $this->Banco->find('all', array(
      'recursive' => -1,
      'conditions' => array('Banco.sucursal_id' => $idSucursal)
    ));
    if (!empty($idMiniEvento)) {
      $d_detalle['nombre'] = 'Venta Impulsador';
    } else {
      $d_detalle['nombre'] = 'Venta Distribuidor';
    }
    $cdetalle = $this->Cajadetalle->find('first', array(
      'recursive' => -1,
      'conditions' => array('Cajadetalle.sucursal_id' => $idSucursal, 'Cajadetalle.nombre LIKE' => $d_detalle['nombre'])
    ));
    if (empty($cdetalle)) {

      $d_detalle['nombre'] = 'Venta Distribuidor';
      $d_detalle['sucursal_id'] = $idSucursal;
      $this->Cajadetalle->create();
      $this->Cajadetalle->save($d_detalle);
      $idDet = $this->Cajadetalle->getLastInsertID();
    } else {
      $idDet = $cdetalle['Cajadetalle']['id'];
    }
    $this->set(compact('bancos', 'idDistribuidor', 'fecha_ini', 'total', 'idDet', 'idSucursal', 'idMiniEvento'));
  }

  public function registra_pago_d() {
    /* debug($this->request->data);
      exit; */
    $this->Distribuidorpago->create();
    $this->Distribuidorpago->save($this->request->data['Distribuidorpago']);
    $idDisp = $this->Distribuidorpago->getLastInsertID();
    foreach ($this->request->data['Cajachica'] as $caj) {
      $total = $this->get_total($caj['banco_id'], $caj['sucursal_id']);
      $caj['distribuidorpago_id'] = $idDisp;
      $this->Cajachica->create();
      $this->Cajachica->save($caj);
      $this->set_total(($total + $caj['monto']), $caj['banco_id'], $caj['sucursal_id']);
    }
    $this->Session->setFlash("Se ha registrado correctamente los Pagos!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function get_pagos_dist($fecha_ini = null, $fecha_fin = null, $idDistribuidor = null) {
    $datos = array();
    $pagos = $this->Distribuidorpago->find('all', array(
      'recursive' => -1,
      'conditions' => array('Distribuidorpago.fecha >=' => $fecha_ini, 'Distribuidorpago.fecha <=' => $fecha_fin, 'Distribuidorpago.distribuidor_id' => $idDistribuidor),
      'fields' => array('Distribuidorpago.faltante', 'Distribuidorpago.otro_ingreso', 'Distribuidorpago.observaciones')
    ));
    if (!empty($pagos)) {
      $datos['faltante'] = 0.00;
      $datos['otro_ingreso'] = 0.00;
      $datos['observaciones'] = '';
      $idSucursal = $this->Session->read('Auth.User.sucursal_id');
      $bancos = $this->Banco->find('all', array(
        'conditions' => array('Banco.sucursal_id' => $idSucursal),
        'fields' => array('id', 'nombre')
      ));
      foreach ($bancos as $key => $ba) {
        $datos['bancos'][$key]['nombre'] = $ba['Banco']['nombre'];
        $monto = $this->Cajachica->find('all', array(
          'recurisve' => 0,
          'conditions' => array(
            'Distribuidorpago.distribuidor_id' => $idDistribuidor,
            'Distribuidorpago.fecha >=' => $fecha_ini, 'Distribuidorpago.fecha <=' => $fecha_fin,
            'Cajachica.banco_id' => $ba['Banco']['id'],
            'Cajachica.sucursal_id' => $idSucursal
          ),
          'group' => array('Distribuidorpago.distribuidor_id'),
          'fields' => array('SUM(Cajachica.monto) as monto_total')
        ));
        if (!empty($monto)) {
          $datos['bancos'][$key]['monto'] = $monto[0][0]['monto_total'];
        } else {
          $datos['bancos'][$key]['monto'] = 0.00;
        }
      }
      foreach ($pagos as $pa) {
        $datos['faltante'] = $datos['faltante'] + $pa['Distribuidorpago']['faltante'];
        $datos['otro_ingreso'] = $datos['otro_ingreso'] + $pa['Distribuidorpago']['otro_ingreso'];
        $datos['observaciones'] = $datos['observaciones'] . ' (' . $pa['Distribuidorpago']['observaciones'] . ')';
      }
    }
    return $datos;
  }

  public function get_pagos_imp($idDistribuidor = null, $idMiniEvento = null) {

    $datos = array();
    $pagos = $this->Distribuidorpago->find('all', array(
      'recursive' => -1,
      'conditions' => array('Distribuidorpago.minievento_id' => $idMiniEvento, 'Distribuidorpago.distribuidor_id' => $idDistribuidor),
      'fields' => array('Distribuidorpago.faltante', 'Distribuidorpago.otro_ingreso', 'Distribuidorpago.observaciones')
    ));
    if (!empty($pagos)) {
      $datos['faltante'] = 0.00;
      $datos['otro_ingreso'] = 0.00;
      $datos['observaciones'] = '';
      $idSucursal = $this->Session->read('Auth.User.sucursal_id');
      $bancos = $this->Banco->find('all', array(
        'conditions' => array('Banco.sucursal_id' => $idSucursal),
        'fields' => array('id', 'nombre')
      ));
      foreach ($bancos as $key => $ba) {
        $datos['bancos'][$key]['nombre'] = $ba['Banco']['nombre'];
        $monto = $this->Cajachica->find('all', array(
          'recurisve' => 0,
          'conditions' => array(
            'Distribuidorpago.distribuidor_id' => $idDistribuidor,
            'Distribuidorpago.minievento_id' => $idMiniEvento,
            'Cajachica.banco_id' => $ba['Banco']['id'],
            'Cajachica.sucursal_id' => $idSucursal
          ),
          'group' => array('Distribuidorpago.distribuidor_id'),
          'fields' => array('SUM(Cajachica.monto) as monto_total')
        ));
        if (!empty($monto)) {
          $datos['bancos'][$key]['monto'] = $monto[0][0]['monto_total'];
        } else {
          $datos['bancos'][$key]['monto'] = 0.00;
        }
      }
      foreach ($pagos as $pa) {
        $datos['faltante'] = $datos['faltante'] + $pa['Distribuidorpago']['faltante'];
        $datos['otro_ingreso'] = $datos['otro_ingreso'] + $pa['Distribuidorpago']['otro_ingreso'];
        $datos['observaciones'] = $datos['observaciones'] . ' (' . $pa['Distribuidorpago']['observaciones'] . ')';
      }
    }
    return $datos;
  }

  public function reporte_vent_dis() {
    $pagosdis = array();
    if (!empty($this->request->data)) {
      //debug($this->request->data);exit;
      $condiciones = array();
      $condiciones['Distribuidorpago.fecha >='] = $this->request->data['Dato']['fecha_ini'];
      $condiciones['Distribuidorpago.fecha <='] = $this->request->data['Dato']['fecha_fin'];
      if (!empty($this->request->data['Dato']['distribuidor_id'])) {
        $condiciones['Distribuidorpago.distribuidor_id'] = $this->request->data['Dato']['distribuidor_id'];
      }
      $this->Distribuidorpago->virtualFields = array(
        'nombre_dis' => "(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM users LEFT JOIN personas ON (personas.id = users.persona_id) WHERE users.id = Distribuidorpago.distribuidor_id)"
      );
      $pagosdis = $this->Distribuidorpago->find('all', array(
        'recursive' => -1,
        'conditions' => $condiciones,
        'fields' => array('Distribuidorpago.id', 'Distribuidorpago.fecha', 'Distribuidorpago.nombre_dis', 'Distribuidorpago.nombre_dis', 'Distribuidorpago.faltante', 'Distribuidorpago.otro_ingreso', 'Distribuidorpago.observaciones')
      ));
    } else {
      $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
      $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
    }
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $distribuidores = $this->User->find('list', array(
      'recursive' => 0,
      'fields' => array('User.id', 'User.nombre_completo', 'Group.name'),
      'conditions' => array('Group.id' => array(2, 7)),
    ));

    $this->set(compact('distribuidores', 'pagosdis'));
  }

  public function get_caja_dis($idDisPago = null) {
    $cajas = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => array('Cajachica.distribuidorpago_id' => $idDisPago),
      'fields' => array('Cajachica.monto', 'Banco.nombre')
    ));
    return $cajas;
  }

  public function get_caja_d_t($fecha_ini = null, $fecha_fin = null, $idDistribuidor = null) {
    $condiciones = array();
    $condiciones['Cajachica.fecha >='] = $fecha_ini;
    $condiciones['Cajachica.fecha <='] = $fecha_fin;
    $condiciones['Cajachica.distribuidorpago_id !='] = NULL;
    if (!empty($idDistribuidor)) {
      $condiciones['Distribuidorpago.distribuidor_id'] = $idDistribuidor;
    }
    $cajas = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => $condiciones,
      'group' => array('Cajachica.banco_id'),
      'fields' => array('Banco.nombre', 'SUM(Cajachica.monto) AS monto_total')
    ));
    return $cajas;
  }

  public function ajax_pagos_dist($idDistribuidor = null) {
    $this->layout = 'ajax';
    $this->Distribuidorpago->virtualFields = array(
      'monto_pagado' => "(SELECT SUM(cajachicas.monto) FROM cajachicas WHERE cajachicas.distribuidorpago_id = Distribuidorpago.id GROUP BY cajachicas.distribuidorpago_id)"
    );
    $pagos = $this->Distribuidorpago->find('all', array(
      'recursive' => -1,
      'conditions' => array('Distribuidorpago.distribuidor_id' => $idDistribuidor),
      'order' => array('Distribuidorpago.id DESC', 'Distribuidorpago.fecha DESC'),
      'limit' => 20
    ));
    //debug($idDistribuidor);exit;
    $distribuidor = $this->User->find('first', array(
      'recursive' => 0,
      'conditions' => array('User.id' => $idDistribuidor),
      'fields' => array('Persona.*')
    ));
    $this->set(compact('pagos', 'distribuidor'));
  }

  public function elimina_pago_dist($idDisPago = null) {
    $cajas = $this->Cajachica->find('all', array(
      'recursive' => -1,
      'conditions' => array('Cajachica.distribuidorpago_id' => $idDisPago)
    ));
    $idSucursal = $this->Session->read('Auth.User.sucursal_id');

    foreach ($cajas as $ca) {
      $total = $this->get_total($ca['Cajachica']['banco_id'], $idSucursal);
      $sw = true;
      if ($ca['Cajachica']['monto'] <= $total) {
        
      } else {
        $sw = FALSE;
      }
    }
    if ($sw) {
      foreach ($cajas as $ca) {
        $total = $this->get_total($ca['Cajachica']['banco_id'], $idSucursal);
        $sw = true;
        $this->Cajachica->delete($ca['Cajachica']['id']);
        $this->set_total(($total - $ca['Cajachica']['monto']), $ca['Cajachica']['banco_id'], $idSucursal);
      }
      $this->Distribuidorpago->delete($idDisPago);
      $this->Session->setFlash("Se elimino correctamente el pago!!", 'msgbueno');
    } else {
      $this->Session->setFlash("No se ha podido eliminar el pago revise sus totales!!", 'msgerror');
    }
    $this->redirect($this->referer());
  }

}
