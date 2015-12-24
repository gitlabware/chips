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

    if ($this->request->is('post')) {

      /* debug($this->request->data);
        die; */
      $tipo = (empty($this->request->data['Recargado']['tipo'])) ? 'entrada' : 'salida';
      //debug($tipo);die;
      $ultimarecarga = $this->Recargado->find('first', array(
        'recursive' => -1,
        'order' => 'Recargado.id DESC'
      ));
      if (empty($ultimarecarga))
        $this->Recargado->create();
      //$tipo = $this->request->data['Recargado']['tipo'];

      if ($tipo == 'entrada') {
        //debug('entro ingreso');
        $porcentajeEntrada = $this->Porcentaje->findByid($this->request->data['Recargado']['porcentaje_id'], null, null, -1);
        $porciento = $porcentajeEntrada['Porcentaje']['nombre'];
        $div = $porciento / 100;
        $this->request->data['Recargado']['entrada'] = $this->request->data['Recargado']['salida'];
        $this->request->data['Recargado']['salida'] = 0;
        $this->request->data['Recargado']['total'] = $ultimarecarga['Recargado']['total'] + ($this->request->data['Recargado']['entrada'] + ($this->request->data['Recargado']['entrada'] * $div));
      } elseif ($tipo == 'salida') {
        //debug('entro salida');
        $this->request->data['Recargado']['salida'] = $this->request->data['Recargado']['salida'];
        if ($ultimarecarga['Recargado']['total'] < $this->request->data['Recargado']['salida']) {
          $this->Session->setFlash('No puede recargar solo hay ' . $ultimarecarga['Recargado']['total'], 'msgerror');
          return $this->redirect(array('action' => 'nuevo'));
        } else {
          $porcentajeDato = $this->Porcentaje->findByid($this->request->data['Recargado']['porcentaje_id'], null, null, -1);
          $valorPorcentaje = $porcentajeDato['Porcentaje']['nombre'];
          $dividiendo = $valorPorcentaje / 100;
          $this->request->data['Recargado']['total'] = $ultimarecarga['Recargado']['total'] - ($this->request->data['Recargado']['salida'] + ($this->request->data['Recargado']['salida'] * $dividiendo));
          $this->request->data['Recargado']['monto'] = $this->request->data['Recargado']['salida'] + ($this->request->data['Recargado']['salida'] * $dividiendo);
        }
      }

      $this->Session->read('Auth.User.id');
      $this->request->data['Recargado']['encargado_id'] = $this->Session->read('Auth.User.id');
      $disPersona = $this->User->findByid($this->request->data['Recargado']['user_id'], null, null, -1);
      $this->request->data['Recargado']['persona_id'] = $disPersona['User']['persona_id'];

      /* debug($this->request->data['Recargado']['encargado_id']);
        die; */
      if ($this->Recargado->save($this->request->data['Recargado'])) {
        $this->Session->setFlash('Registro Correctamente.', 'msgbueno');
        return $this->redirect(array('action' => 'nuevo'));
      } else {
        $this->Session->setFlash('Registro Correctamente.', 'msgerror');
        return $this->redirect(array('action' => 'nuevo'));
      }
    } else {
      $hoy = $this->Recargado;
      $ultimo = $this->Recargado->find('first', array(
        'recursive' => -1,
        'order' => 'Recargado.id DESC'
      ));
      $movimientosHoy = $this->Recargado->find('all', array(
        'recursive' => 0,
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
    }

    $distribuidor = $this->User->find('list', array(
      'recursive' => 0,
      'fields' => 'Persona.nombre',
      'conditions' => array('Group.name' => 'Distribuidores'),
    ));
    $porcentaje = $this->Porcentaje->find('list', array('fields' => 'Porcentaje.nombre'));
    //debug($distribuidor);exit;
    $this->set(compact('distribuidor', 'porcentaje', 'tipo'));
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

  public function get_total() {
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

  //Cambia el total buscando el ultimo registro..... se debe de llamar a esta funcion al termino de las demas
  public function set_total($total = null) {
    $ult_recarga = $this->Recargado->find('first', array(
      'recursive' => -1,
      'order' => 'Recargado.id DESC',
      'fields' => 'Recargado.id'
    ));
    $d_rec['total'] = $total;
    if (!empty($ult_recarga)) {
      $this->Recargado->id = $ult_recarga['Recargado']['id'];
      $this->Recargado->save($d_rec);
    } else {
      if ($total > 0) {
        $this->Recargado->create();
        $d_rec['user_id'] = $this->Session->read('Auth.User.id');
        $this->Recargado->save($d_rec);
      }
    }
  }

  public function elimina($idRecargado = null) {
    $recargado = $this->Recargado->find('first', array(
      'recursive' => -1,
      'conditions' => array('Recargado.id' => $idRecargado),
      'fields' => array('Recargado.total', 'Recargado.entrada', 'Recargado.salida')
    ));
    $total = $this->get_total();
    if (!empty($recargado['Recargado']['entrada']) && $recargado['Recargado']['entrada'] != 0) {
      if ($recargado['Recargado']['entrada'] <= $total) {
        $total = $total - $recargado['Recargado']['entrada'];
      } else {
        $this->Session->setFlash("No se puede eliminar porque el monto total es $total", 'msgerror');
        $this->redirect($this->referer());
      }
    } elseif (!empty($recargado['Recargado']['salida']) && $recargado['Recargado']['salida'] != 0) {

      $total = $total + $recargado['Recargado']['salida'];
    } else {
      $this->Session->setFlash("No se puede eliminar porque los montos nulos", 'msgerror');
      $this->redirect($this->referer());
    }
    $this->Recargado->delete($idRecargado);
    $this->set_total($total);
    $this->Session->setFlash("Se elimino correctamente!!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function reporte() {
    $recargas = array();
    if (!empty($this->request->data)) {
      
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $recargas = $this->Recargado->find('all',array(
        'recursive' => 0,
        'conditions' => array('DATE(Recargado.created) >=' => $fecha_ini,'DATE(Recargado.created) <=' => $fecha_fin)
      ));
      
    }
    $this->set(compact('recargas'));
  }

}
