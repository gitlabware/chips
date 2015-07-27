
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

  public function get_total() {
    $caja = $this->Cajachica->find('first', array(
      'recursive' => -1,
      'order' => 'id DESC'
    ));
    if (empty($caja)) {
      return 0.00;
    } else {
      return $caja['Cajachica']['total'];
    }
  }

  public function set_total($total = null) {
    $caja = $this->Cajachica->find('first', array(
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
        'Cajachica.fecha >=' => $this->request->data['Dato']['fecha_ini'],
        'Cajachica.fecha <=' => $this->request->data['Dato']['fecha_fin'],
        'Cajachica.tipo' => 'Ingreso'
      ),
      'fields' => array('Cajachica.*', 'Cajadetalle.*')
    ));
    $cajachica_gas = $this->Cajachica->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Cajachica.fecha >=' => $this->request->data['Dato']['fecha_ini'],
        'Cajachica.fecha <=' => $this->request->data['Dato']['fecha_fin'],
        'Cajachica.tipo' => 'Gasto'
      ),
      'fields' => array('Cajachica.*', 'Cajadetalle.*')
    ));
    $detalles = $this->Cajadetalle->find('list', array('fields' => 'Cajadetalle.nombre'));
    $this->set(compact('cajachica_ing', 'cajachica_gas', 'total', 'detalles'));
  }

  public function registra_caja() {
    if (!empty($this->request->data['Cajadetalle']['nombre'])) {
      $this->Cajadetalle->create();
      $this->Cajadetalle->save($this->request->data['Cajadetalle']);
      $this->request->data['Cajachica']['cajadetalle_id'] = $this->Cajadetalle->getLastInsertID();
    }
    $dcaja = $this->request->data['Cajachica'];
    if (!empty($dcaja)) {
      $total = $this->get_total();
      if ($dcaja['tipo'] == 'Gasto') {
        if ($dcaja['monto'] <= $total) {
          $this->Cajachica->create();
          $dcaja['total'] = $total - $dcaja['monto'];
          $this->Cajachica->save($dcaja);
          $this->Session->setFlash("Se registro correctamente en cajachica!!", 'msgbueno');
          $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash("El gasto no debe exceder al total de $total", 'msgerror');
        }
      } else {
        $this->Cajachica->create();
        $dcaja['total'] = $total + $dcaja['monto'];
        $this->Cajachica->save($dcaja);
        $this->Session->setFlash("Se registro correctamente en cajachica!!", 'msgbueno');
        $this->redirect(array('action' => 'index'));
      }
    } else {
      $this->Session->setFlash("No se pudo registrar intente nuevamente!!", 'msgerror');
    }
  }

  public function elimina($idCaja = NULL) {
    $caja = $this->Cajachica->findByid($idCaja, null, null, -1);
    $total = $this->get_total();
    if ($caja['Cajachica']['tipo'] == 'Ingreso') {
      if ($caja['Cajachica']['monto'] <= $total) {
        $this->Cajachica->delete($caja['Cajachica']['id']);
        $this->set_total(($total - $caja['Cajachica']['monto']));
        $this->Session->setFlash("Se elimino correctamente!!", 'msgbueno');
      } else {
        $this->Session->setFlash("El monto del ingreso no puede exceder al total de $total", 'msgerror');
      }
    } else {
      $this->Cajachica->delete($caja['Cajachica']['id']);
      $this->set_total(($total + $caja['Cajachica']['monto']));
      $this->Session->setFlash("Se elimino correctamente!!", 'msgbueno');
    }
    $this->redirect(array('action' => 'index'));
  }

}
