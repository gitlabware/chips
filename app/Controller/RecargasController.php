<?php

class RecargasController extends AppController {

  public $name = 'Recargas';
  public $layout = 'viva';
  public $uses = array('Recarga', 'Recargados', 'Listarecarga', 'Cliente', 'Movimientosrecarga', 'User', 'Persona', 'Porcentaje');
  public $components = array('Fechasconvert');

  public function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  //public

  public function index() {
    
  }

  public function listarecargas() {

    $today = date('Y-m-d') . '%';

    $recargas = $this->Recarga->find(
      'all', array(
      'conditions' => array('Recarga.created like' => $today),
      'order' => array('Recarga.id DESC'),
      'recursive' => 0
    ));
    $this->set(compact('recargas'));


    //debug($recargas);exit;
  }

  public function notifica() {
    $ultimor = $this->Recarga->find('first', array('order' => array('Recarga.id DESC')));
    $idul = $ultimor['Recarga']['id'];
    //debug($ultimor);exit;
    return $idul;
  }

  public function todas() {
    $recargas = $this->Recarga->find(
      'all', array(
      'order' => array('Recarga.id DESC'),
      'recursive' => 0
    ));

    $this->set(compact('recargas'));
  }

  public function cambiaestado() {
    if (!empty($this->request->data)) {

      $id = $this->request->data['Recarga']['id'];
      $estado = $this->request->data['Recarga']['estado'];

      $data = array();

      $dato = $this->Recarga->find('first', array('conditions' => array('Recarga.id' => $id), 'recursive' => -1));

      $cantidad = $dato['Recarga']['total'];

      $recarga = $this->Movimientosrecarga->find('first', array('order' => array('Movimientosrecarga.id DESC')));

      $saldo = $recarga['Movimientosrecarga']['saldo'];
      $saldoaux = $recarga['Movimientosrecarga']['saldo'];
      $fecha = $recarga['Movimientosrecarga']['fecha'];
      $total = $recarga['Movimientosrecarga']['saldo_total'];

      if ($estado == 2) {
        //echo 'con estado';
        $data = array('id' => $this->request->data['Recarga']['id'], 'estado' => '0');
      } else {
        //echo 'sin estado';
        $data = array('id' => $this->request->data['Recarga']['id'], 'estado' => '1');

        $today = date('Y-m-d');

        if ($cantidad > $total) {
          $this->Session->setFlash('Imposible realizar el monto de la recarga solicitada es mayor al saldo, saldo actual ' . $total, 'msgerror');
          $this->redirect(array('action' => 'todas'));
        }
        if ($fecha == $today) {
          $salida = $recarga['Movimientosrecarga']['salida'] + $cantidad;
          $ingreso = $recarga['Movimientosrecarga']['ingreso'];
        } else {
          $salida = $cantidad;
          $ingreso = 0;
        }
        $saldo = $recarga['Movimientosrecarga']['saldo_total'] - $cantidad;

        $this->Movimientosrecarga->create();
        $this->request->data['Movimientosrecarga']['user_id'] = $this->Session->read('Auth.User.id');
        $this->request->data['Movimientosrecarga']['ingreso'] = $ingreso;
        $this->request->data['Movimientosrecarga']['salida'] = $salida;
        if ($cantidad > $saldoaux) {
          $this->request->data['Movimientosrecarga']['saldo'] = 0;
        } else {
          $this->request->data['Movimientosrecarga']['saldo'] = $saldoaux - $cantidad;
        }
        $this->request->data['Movimientosrecarga']['saldo_total'] = $saldo;
        $this->request->data['Movimientosrecarga']['recarga_id'] = $id;
        $this->request->data['Movimientosrecarga']['fecha'] = $today;

        $this->Movimientosrecarga->save($this->request->data['Movimientosrecarga']);
      }


      if ($this->Recarga->save($data)) {
        //debug($data);exit;
        $this->Session->setFlash('Recarga realizada', 'msgbueno');
        $this->redirect(array('action' => 'listarecargas'), null, true);
      } else {
        $this->Session->setFlash('No se pudo modificar', 'msgerror');
        $this->redirect(array('action' => 'listarecargas'), null, true);
      }
    } else {
      $this->Session->setFlash('No se pudo cambiar', 'msgerror');
      $this->redirect(array('action' => 'listarecargas'), null, true);
    }
  }

  function editar($id = null, $ido = null) {
    $this->Productosprecio->id = $id;
    if (!$id) {
      $this->Session->setFlash('No existe el producto');
      $this->redirect(array('action' => 'precios', $id), null, true);
    }

    if (empty($this->data)) {
      $this->data = $this->Productosprecio->read(); //find(array('id' => $id));
    } else {
      if ($this->Productosprecio->save($this->data)) {
        $this->Session->setFlash('Los datos fueron modificados', 'mensajebueno');
        $this->redirect(array('action' => 'precios', $ido), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!');
      }
    }
    //$precios = $this->Productosprecio->find('all', array ('recursive'=>-1));
    //$this->set(compact('precios'));
  }

  public function add($id = null) {
    if ($this->request->is('post')) {

      $this->Recarga->create();
      //debug($this->request->data); 

      if ($this->Recarga->save($this->request->data['Recarga'])) {

        //debug($iduser);exit;

        $this->Session->setFlash(__('The user has been saved'));

        $this->redirect(array('action' => 'listarecargas'));
      } else {
        $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
      }
    }

    //$groups = $this->User->Group->find('all', array ('recursive'=>-1));
    //  $this->set(compact('groups'));
  }

  //funcion recarga M 

  public function delete($id = null) {
    $this->Recarga->id = $id;
    if (!$this->Recarga->exists()) {
      throw new NotFoundException(__('Invalid cajachica'));
    }
    if ($this->Recarga->delete()) {
      $this->Session->setFlash('El registro fue eliminado.');
    } else {
      $this->Session->setFlash('El registro no fue eliminado.');
    }
    return $this->redirect(array('action' => 'nuevo'));
  }

  public function ajaxmonto($monto = null) {
    $ultimarecarga = $this->Recarga->find('first', array(
      'recursive' => -1,
      'order' => 'Recarga.id DESC'
    ));
    //debug($porcentaje); exit;
    $this->layout = 'ajax';
    $tipo = $this->request->data['Recarga']['tipo'];
    if ($tipo == 'ingreso') {
      $porcentajeEntrada = $this->Porcentaje->findByid($this->request->data['Recarga']['porcentaje_id'], null, null, -1);
      $porciento = $porcentajeEntrada['Porcentaje']['nombre'];
      $div = $porciento / 100;
      $this->request->data['Recarga']['entrada'] = $this->request->data['Recarga']['salida'];
      $this->request->data['Recarga']['total'] = $ultimarecarga['Recarga']['total'] + ($this->request->data['Recarga']['salida'] * $div);
    } elseif ($tipo == 'salida') {
      // debug($ultimarecarga['Recarga']['total']); 
      //debug($this->request->data['Recarga']['salida']);
      //exit;
      $this->request->data['Recarga']['salida'] = $this->request->data['Recarga']['salida'];
      if ($ultimarecarga['Recarga']['total'] < $this->request->data['Recarga']['salida']) {
        
      } else {
        $porcentajeDato = $this->Porcentaje->findByid($this->request->data['Recarga']['porcentaje_id'], null, null, -1);
        $valorPorcentaje = $porcentajeDato['Porcentaje']['nombre'];
        $dividiendo = $valorPorcentaje / 100;
        $this->request->data['Recarga']['total'] = $ultimarecarga['Recarga']['total'] - ($this->request->data['Recarga']['salida'] + ($this->request->data['Recarga']['salida'] * $dividiendo));
        $this->request->data['Recarga']['monto'] = $this->request->data['Recarga']['salida'] + ($this->request->data['Recarga']['salida'] * $dividiendo);
      }
    }
    $capturaMonto = $this->request->data['Recarga']['monto'];
    $this->set(compact('capturaMonto'));
  }

  public function estadorecargas() {
    $recarga = $this->Movimientosrecarga->find('first', array('order' => array('Movimientosrecarga.id DESC')));
    $realizados = $this->Recarga->find('all', array('conditions' => array('Recarga.estado' => 1), 'order' => array('Recarga.id DESC')));

    $this->set(compact('recarga', 'realizados'));
  }

  public function estadorecargas2() {
    $recarga = $this->Movimientosrecarga->find('first', array('order' => array('Movimientosrecarga.id DESC')));
    $realizados = $this->Recarga->find('all', array('conditions' => array('Recarga.estado' => 1), 'order' => array('Recarga.id DESC')));

    $this->set(compact('recarga', 'realizados'));
  }

  public function ajaxanunciarecargas() {
    $this->layout = 'ajax';
    $dato = $this->Recarga->find('count', array('conditions' => array('Recarga.estado' => 0)));
    $this->set(compact('dato'));
  }

}

?>
