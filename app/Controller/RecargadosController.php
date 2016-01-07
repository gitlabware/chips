<?php

App::uses('AppController', 'Controller');

/**
 * Recargados Controller
 *
 * @property Recargado $Recargado
 * @property PaginatorComponent $Paginator
 */
class RecargadosController extends AppController {

  //public $name = 'Recargas';
  public $layout = 'viva';
  public $uses = array('Recargado', 'Listarecarga', 'Cliente', 'Movimientosrecarga', 'User', 'Persona', 'Porcentaje');
  public $components = array('Fechasconvert');

  /**
   * Components
   *
   * @var array
   */
  //public $components = array('Paginator');
  public function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->Recargado->recursive = 0;
    $this->set('recargados', $this->Paginator->paginate());
  }

  /**
   * view method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function view($id = null) {
    if (!$this->Recargado->exists($id)) {
      throw new NotFoundException(__('Invalid recargado'));
    }
    $options = array('conditions' => array('Recargado.' . $this->Recargado->primaryKey => $id));
    $this->set('recargado', $this->Recargado->find('first', $options));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if ($this->request->is('post')) {
      $this->Recargado->create();
      if ($this->Recargado->save($this->request->data)) {
        $this->Session->setFlash(__('The recargado has been saved.'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The recargado could not be saved. Please, try again.'));
      }
    }
    $users = $this->Recargado->User->find('list');
    $encargados = $this->Recargado->Encargado->find('list');
    $personas = $this->Recargado->Persona->find('list');
    $porcentajes = $this->Recargado->Porcentaje->find('list');
    $this->set(compact('users', 'encargados', 'personas', 'porcentajes'));
  }

  /**
   * edit method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function edit($id = null) {
    if (!$this->Recargado->exists($id)) {
      throw new NotFoundException(__('Invalid recargado'));
    }
    if ($this->request->is(array('post', 'put'))) {
      if ($this->Recargado->save($this->request->data)) {
        $this->Session->setFlash(__('The recargado has been saved.'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The recargado could not be saved. Please, try again.'));
      }
    } else {
      $options = array('conditions' => array('Recargado.' . $this->Recargado->primaryKey => $id));
      $this->request->data = $this->Recargado->find('first', $options);
    }
    $users = $this->Recargado->User->find('list');
    $encargados = $this->Recargado->Encargado->find('list');
    $personas = $this->Recargado->Persona->find('list');
    $porcentajes = $this->Recargado->Porcentaje->find('list');
    $this->set(compact('users', 'encargados', 'personas', 'porcentajes'));
  }

  /**
   * delete method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function delete1ante($id = null) {
    $this->Recargado->id = $id;
    if (!$this->Recargado->exists()) {
      throw new NotFoundException(__('Invalid recargado'));
    }
    $this->request->allowMethod('post', 'delete');
    if ($this->Recargado->delete()) {
      $this->Session->setFlash(__('The recargado has been deleted.'));
    } else {
      $this->Session->setFlash(__('The recargado could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
  }

  public function nuevo() {

    if (!empty($this->request->data['Dato'])) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    } else {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
      $fecha_fin = $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
    }

    $hoy = $this->Recargado;
    $ultimo = $this->Recargado->find('first', array(
      'recursive' => -1,
      'order' => 'Recargado.id DESC'
    ));
    $movimientosHoy = $this->Recargado->find('all', array(
      'recursive' => 0,
      'conditions' => array('Recargado.modified >=' => $fecha_ini,'Recargado.modified <=' => $fecha_fin),
      'order' => array('Recargado.id DESC')
    ));
    //debug($movimientosHoy);
    $movimientosHoy2 = $this->Recargado->find('all', array(
      'recursive' => 0,
      'order' => array('Recargado.id DESC'),
      'group' => array('Recargado.porcentaje_id'),
      'fields' => array('Porcentaje.nombre', 'SUM(Recargado.salida) as recargados', 'SUM(Recargado.monto) as rec_porcentaje'),
      'conditions' => array('Recargado.entrada' => 0),
    ));

    $movimientosDistribuidor = $this->Recargado->find('all', array(
      'recursive' => 0,
      'order' => array('Recargado.id DESC'),
      'group' => array('Recargado.persona_id'),
      'fields' => array('Persona.nombre', 'SUM(Recargado.salida) as recargados', 'SUM(Recargado.monto) as rec_porcentaje'),
      'conditions' => array('Recargado.entrada' => 0),
    ));

    $ultimototal = $this->Recargado->find('first', array(
      'recursive' => -1,
      'order' => array('Recargado.id DESC'),
      'fields' => array('Recargado.total')
    ));
    $this->set(compact('hoy', 'movimientosHoy', 'ultimo', 'movimientosHoy2', 'ultimototal', 'movimientosDistribuidor'));

    $sql_p = "(SELECT recargados.total_distribuidor FROM recargados WHERE recargados.persona_id = Persona.id ORDER BY recargados.id DESC LIMIT 1)";
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno, '(',( IF( ISNULL($sql_p),0,$sql_p ) ),')')"
    );
    $distribuidor = $this->User->find('list', array(
      'recursive' => 0,
      'fields' => array('User.id', 'User.nombre_completo'),
      'conditions' => array('Group.name' => 'Distribuidores'),
    ));
    $porcentaje = $this->Porcentaje->find('list', array('fields' => 'Porcentaje.nombre'));
    //debug($distribuidor);exit;

    $this->set(compact('distribuidor', 'porcentaje', 'tipo'));
  }

  public function registra_recarga() {
    if ($this->request->is('post')) {

      /* debug($this->request->data);
        die; */
      if ($this->request->data['Recargado']['tipo'] == 1) {
        $tipo = 'entrada';
      } elseif ($this->request->data['Recargado']['tipo'] == 2) {
        $tipo = 'salida';
      } else {
        $tipo = 'entrada-distribuidor';
      }
      //debug($tipo);die;
      $this->request->data['Recargado']['encargado_id'] = $this->Session->read('Auth.User.id');
      $disPersona = $this->User->findByid($this->request->data['Recargado']['user_id'], null, null, -1);

      if (!empty($disPersona)) {
        $idPersona = $disPersona['User']['persona_id'];
        ;
      } else {
        $idPersona = NULL;
      }


      /* $ultimarecarga = $this->Recargado->find('first', array(
        'recursive' => -1,
        'conditions' => array('Recargado.user_id' => $this->request->data['Recargado']['user_id']),
        'order' => 'Recargado.id DESC'
        )); */
      //$this->Recargado->create();
      //$tipo = $this->request->data['Recargado']['tipo'];
      //$u_total = $this->get_total($idPersona);
      //debug($tipo);exit;
      if ($tipo == 'entrada') {
        //debug('entro ingreso');
        $u_total = $this->get_total(NULL);
        $porcentajeEntrada = $this->Porcentaje->findByid($this->request->data['Recargado']['porcentaje_id'], null, null, -1);
        $porciento = $porcentajeEntrada['Porcentaje']['nombre'];
        $div = $porciento / 100;
        $this->request->data['Recargado']['entrada'] = $this->request->data['Recargado']['salida'];
        $this->request->data['Recargado']['salida'] = 0;

        $this->request->data['Recargado']['monto'] = ($this->request->data['Recargado']['entrada'] + ($this->request->data['Recargado']['entrada'] * $div));

        if (!empty($idPersona)) {
          $this->request->data['Recargado']['persona_id'] = $idPersona;
          if ($u_total < $this->request->data['Recargado']['monto']) {
            $this->Session->setFlash('No puede recargar solo hay ' . $u_total . ' en Central', 'msgerror');
            return $this->redirect(array('action' => 'nuevo'));
          }
          $this->request->data['Recargado']['total'] = $u_total - ($this->request->data['Recargado']['entrada'] + ($this->request->data['Recargado']['entrada'] * $div));
          $u_d_total = $this->get_total($idPersona);
          $this->request->data['Recargado']['total_distribuidor'] = $u_d_total + $this->request->data['Recargado']['monto'];
        } else {
          $this->request->data['Recargado']['total'] = $u_total + ($this->request->data['Recargado']['entrada'] + ($this->request->data['Recargado']['entrada'] * $div));
        }
      } elseif ($tipo == 'salida') {
        //debug('entro salida');
        $u_total = $this->get_total(NULL);
        $this->request->data['Recargado']['salida'] = $this->request->data['Recargado']['salida'];
        if ($u_total < $this->request->data['Recargado']['salida']) {
          $this->Session->setFlash('No puede recargar solo hay ' . $u_total . ' en Central', 'msgerror');
          return $this->redirect(array('action' => 'nuevo'));
        } else {
          $porcentajeDato = $this->Porcentaje->findByid($this->request->data['Recargado']['porcentaje_id'], null, null, -1);
          $valorPorcentaje = $porcentajeDato['Porcentaje']['nombre'];
          $dividiendo = $valorPorcentaje / 100;
          $this->request->data['Recargado']['persona_id'] = $idPersona;
          $this->request->data['Recargado']['total'] = $u_total - ($this->request->data['Recargado']['salida'] + ($this->request->data['Recargado']['salida'] * $dividiendo));
          $this->request->data['Recargado']['monto'] = $this->request->data['Recargado']['salida'] + ($this->request->data['Recargado']['salida'] * $dividiendo);
          if (!empty($idPersona)) {
            $u_d_total = $this->get_total($idPersona);
            $this->request->data['Recargado']['total_distribuidor'] = $u_d_total;
          }
        }
      } else {
        if (!empty($idPersona)) {

          $u_d_total = $this->get_total($idPersona);
          if ($u_d_total < $this->request->data['Recargado']['salida']) {
            $this->Session->setFlash('No puede recargar solo tiene ' . $u_d_total . ' el distribuidor', 'msgerror');
            return $this->redirect(array('action' => 'nuevo'));
          } else {
            $porcentajeDato = $this->Porcentaje->findByid($this->request->data['Recargado']['porcentaje_id'], null, null, -1);
            $valorPorcentaje = $porcentajeDato['Porcentaje']['nombre'];
            $dividiendo = $valorPorcentaje / 100;
            $this->request->data['Recargado']['persona_id'] = $idPersona;
            $this->request->data['Recargado']['total'] = $this->get_total(NULL);
            $this->request->data['Recargado']['monto'] = $this->request->data['Recargado']['salida'] + ($this->request->data['Recargado']['salida'] * $dividiendo);

            $this->request->data['Recargado']['total_distribuidor'] = $u_d_total - $this->request->data['Recargado']['monto'];
          }
        } else {
          $this->Session->setFlash("No ha seleccionado al distribuidor!!", 'msgerror');
          return $this->redirect(array('action' => 'nuevo'));
        }
      }

      /* debug($this->request->data['Recargado']['encargado_id']);
        die; */
      $this->Recargado->create();
      if ($this->Recargado->save($this->request->data['Recargado'])) {
        $this->Session->setFlash('Registro Correctamente.', 'msgbueno');
        return $this->redirect($this->referer());
      } else {
        $this->Session->setFlash('Registro Correctamente.', 'msgerror');
        return $this->redirect($this->referer());
      }
    } else {
      $this->Session->setFlash("No se ha podido registrar intente nuevamente!!", 'msgerror');
      $this->redirect($this->referer());
    }
  }

  public function delete($id = null) {
    $this->Recargado->id = $id;
    if (!$this->Recargado->exists()) {
      throw new NotFoundException(__('Invalid cajachica'));
    }
    if ($this->Recargado->delete()) {
      $this->Session->setFlash('El registro fue eliminado.');
    } else {
      $this->Session->setFlash('El registro no fue eliminado.');
    }
    return $this->redirect(array('action' => 'nuevo'));
  }

  public function get_total($idPersona = null) {
    if (!empty($idPersona)) {
      $ult_recarga = $this->Recargado->find('first', array(
        'recursive' => -1,
        'order' => 'Recargado.id DESC',
        'fields' => 'Recargado.total_distribuidor',
        'conditions' => array('Recargado.persona_id' => $idPersona)
      ));
      if (!empty($ult_recarga)) {
        return $ult_recarga['Recargado']['total_distribuidor'];
      } else {
        return 0;
      }
    } else {
      $ult_recarga = $this->Recargado->find('first', array(
        'recursive' => -1,
        'order' => 'Recargado.id DESC',
        'fields' => 'Recargado.total'
      ));
      if (!empty($ult_recarga)) {
        return $ult_recarga['Recargado']['total'];
      } else {
        return 0;
      }
    }
  }

  //Cambia el total buscando el ultimo registro..... se debe de llamar a esta funcion al termino de las demas
  public function set_total($total = null, $idPersona = null) {

    if (!empty($idPersona)) {
      $ult_recarga = $this->Recargado->find('first', array(
        'recursive' => -1,
        'order' => 'Recargado.id DESC',
        'fields' => 'Recargado.id',
        'conditions' => array('Recargado.persona_id' => $idPersona)
      ));

      $d_rec['total_distribuidor'] = $total;
      if (!empty($ult_recarga)) {
        $this->Recargado->id = $ult_recarga['Recargado']['id'];
        $this->Recargado->save($d_rec);
      }
    } else {
      $ult_recarga = $this->Recargado->find('first', array(
        'recursive' => -1,
        'order' => 'Recargado.id DESC',
        'fields' => 'Recargado.id'
      ));
      $d_rec['total'] = $total;
      if (!empty($ult_recarga)) {
        $this->Recargado->id = $ult_recarga['Recargado']['id'];
        $this->Recargado->save($d_rec);
      }
    }
  }

  public function elimina($idRecargado = null) {
    $recargado = $this->Recargado->find('first', array(
      'recursive' => -1,
      'conditions' => array('Recargado.id' => $idRecargado),
      'fields' => array('Recargado.total', 'Recargado.monto', 'Recargado.entrada', 'Recargado.salida', 'Recargado.persona_id', 'Recargado.tipo')
    ));
    if ($recargado['Recargado']['tipo'] == '1' && !empty($recargado['Recargado']['persona_id'])) {
      //debug($recargado);exit;
      $total_u = $this->get_total($recargado['Recargado']['persona_id']);
      if ($total_u >= $recargado['Recargado']['monto']) {
        $total = $this->get_total(NULL);
        $this->Recargado->delete($idRecargado);
        $this->set_total(($total_u - $recargado['Recargado']['monto']), $recargado['Recargado']['persona_id']);
        $this->set_total(($total + $recargado['Recargado']['monto']), NULL);
      } else {
        $this->Session->setFlash("No se ha podido eliminar la recarga el distribuidor no tiene suficiente para reponer!!!", 'msgerror');
        $this->redirect($this->referer());
      }
    } elseif ($recargado['Recargado']['tipo'] == '1' && empty($recargado['Recargado']['persona_id'])) {
      $total = $this->get_total(NULL);
      if ($total >= $recargado['Recargado']['monto']) {
        $this->Recargado->delete($idRecargado);
        $this->set_total(($total - $recargado['Recargado']['monto']), NULL);
      }
    } elseif ($recargado['Recargado']['tipo'] == '2') {
      $total = $this->get_total(NULL);
      if (!empty($recargado['Recargado']['persona_id'])) {
        $total_u = $this->get_total($recargado['Recargado']['persona_id']);
      }
      $this->Recargado->delete($idRecargado);
      $this->set_total(($total + $recargado['Recargado']['monto']), NULL);
      if (!empty($recargado['Recargado']['persona_id'])) {
        $this->set_total(($total_u), $recargado['Recargado']['persona_id']);
      }
    } elseif ($recargado['Recargado']['tipo'] == '3') {
      $total_u = $this->get_total($recargado['Recargado']['persona_id']);
      $total = $this->get_total(NULL);
      $this->Recargado->delete($idRecargado);
      $this->set_total(($total_u + $recargado['Recargado']['monto']), $recargado['Recargado']['persona_id']);
      $this->set_total($total, NULL);
    }

    $this->Session->setFlash("Se elimino correctamente!!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function reporte() {
    $recargas = array();
    if (!empty($this->request->data)) {

      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $recargas = $this->Recargado->find('all', array(
        'recursive' => 0,
        'conditions' => array('DATE(Recargado.created) >=' => $fecha_ini, 'DATE(Recargado.created) <=' => $fecha_fin)
      ));
    }
    $this->set(compact('recargas'));
  }

  public function get_recargas_dist($fecha_ini = null, $fecha_fin = null, $idPersona = null, $idPorcentaje = null, $tipo = null) {

    $recargas = $this->Recargado->find('all', array(
      'recursive' => -1,
      'conditions' => array('DATE(Recargado.created) >=' => $fecha_ini, 'DATE(Recargado.created) <=' => $fecha_fin, 'Recargado.persona_id' => $idPersona, 'Recargado.porcentaje_id' => $idPorcentaje, 'Recargado.tipo' => $tipo),
      'group' => array('Recargado.porcentaje_id'),
      'fields' => array('SUM(Recargado.salida) monto_total')
    ));
    if (!empty($recargas)) {
      return $recargas[0][0]['monto_total'];
    } else {
      return 0;
    }
  }

}
