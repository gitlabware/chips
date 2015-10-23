
<?php

App::uses('AppController', 'Controller');

/**
 * Almacenes Controller
 *
 * @property Almacene $Almacene
 */
class CajachicasController extends AppController {

  public $uses = array('Cajachica', 'Cajadetalle');
  public $layout = 'viva';

  public function get_total($idSucursal = null) {
    $caja = $this->Cajachica->find('first', array(
      'recursive' => -1,
      'conditions' => array('Cajachica.sucursal_id' => $idSucursal),
      'order' => 'id DESC'
    ));
    if (empty($caja)) {
      return 0.00;
    } else {
      return $caja['Cajachica']['total'];
    }
  }

  public function set_total($total = null, $idSucursal = null) {
    $caja = $this->Cajachica->find('first', array(
      'conditions' => array('Cajachica.sucursal_id' => $idSucursal),
      'recursive' => -1,
      'order' => 'id DESC'
    ));
    if (!empty($caja)) {
      $this->Cajachica->id = $caja['Cajachica']['id'];
      $dcaja['total'] = $total;
      $dcaja['user_id'] = $this->Session->read('Auth.User.id');
      $this->Cajachica->save($dcaja);
    } else {
      if ($total != 0) {
        $this->Cajachica->create();
        $dcaja['total'] = $total;
        $dcaja['user_id'] = $this->Session->read('Auth.User.id');
        $this->Cajachica->save($dcaja);
      }
    }
  }

  public function index() {
    $total = $this->get_total();
    if ($this->request->data['Cajachica']) {
      $this->registra_caja();
    }
    if (empty($this->request->data['Dato']['fecha_ini'])) {
      $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
    }
    if (empty($this->request->data['Dato']['fecha_fin'])) {
      $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
    }

    $cajachica_ing = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Cajachica.sucursal_id' => NULL,
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
        'Cajachica.sucursal_id' => NULL,
        'Cajachica.fecha >=' => $this->request->data['Dato']['fecha_ini'],
        'Cajachica.fecha <=' => $this->request->data['Dato']['fecha_fin'],
        'Cajachica.tipo' => 'Gasto'
      ),
      'fields' => array('Cajachica.*', 'Cajadetalle.*')
    ));
    $detalles = $this->Cajadetalle->find('list', array('conditions' => array('Cajadetalle.sucursal_id' => NULL), 'fields' => 'Cajadetalle.nombre'));
    $this->set(compact('cajachica_ing', 'cajachica_gas', 'total', 'detalles'));
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
      $total = $this->get_total($this->request->data['Cajachica']['sucursal_id']);
      if ($dcaja['tipo'] == 'Gasto') {
        if ($dcaja['monto'] <= $total) {
          $this->Cajachica->create();
          $dcaja['total'] = $total - $dcaja['monto'];
          $this->Cajachica->save($dcaja);
          $this->Session->setFlash("Se registro correctamente en cajachica!!", 'msgbueno');
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
    $total = $this->get_total($idSucursal);
    if ($caja['Cajachica']['tipo'] == 'Ingreso') {
      if ($caja['Cajachica']['monto'] <= $total) {
        $this->Cajachica->delete($caja['Cajachica']['id']);
        $this->set_total(($total - $caja['Cajachica']['monto']),$idSucursal);
        $this->Session->setFlash("Se elimino correctamente!!", 'msgbueno');
      } else {
        $this->Session->setFlash("El monto del ingreso no puede exceder al total de $total", 'msgerror');
      }
    } else {
      $this->Cajachica->delete($caja['Cajachica']['id']);
      $this->set_total(($total + $caja['Cajachica']['monto']));
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
    $detalles = $this->Cajadetalle->find('list', array('conditions' => array('Cajadetalle.sucursal_id' => $idSucursal), 'fields' => 'Cajadetalle.nombre'));
    $this->set(compact('cajachica_ing', 'cajachica_gas', 'total', 'detalles'));
  }
  

}
