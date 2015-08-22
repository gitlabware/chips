<?php

class Rutascontroller extends AppController {

  public $layout = 'viva';
  public $uses = array('Ruta', 'Cliente');
  var $components = array('RequestHandler', 'DataTable');

  public function beforeFilter() {
     parent::beforeFilter();
        if ($this->RequestHandler->responseType() == 'json') {
            $this->RequestHandler->setContent('json', 'application/json');
        }
        //$this->Auth->allow();
  }

  public function index() {
    $this->paginate = array('Ruta' => array('limit' => 100));
    $this->set('rutas', $this->paginate('Ruta'));
  }

  public function add() {
    if ($this->request->is('post')) {
      $this->Ruta->create();
      if ($this->Ruta->save($this->request->data)) {
        $this->Session->setFlash('Registrado Correctamente', 'msgbueno');
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Error el registrar!', 'msgerror');
      }
    }
  }

  public function edit($id = null) {
    $this->Ruta->id = $id;
    if (!$this->Ruta->exists()) {
      throw new NotFoundException(__('Invalido'));
    }
    if ($this->request->is(array('post', 'put'))) {

      if ($this->Ruta->save($this->request->data)) {
        $this->Session->setFlash('Registro exitoso', 'msgbueno');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Error al registrar', 'msgerror');
      }
    } else {
      $this->request->data = $this->Ruta->read(null, $id);
    }
  }

  public function delete($id = null) {
    $this->Ruta->id = $id;
    if (!$this->Ruta->exists()) {
      throw new NotFoundException(__('Categoria invalido'));
    }
    if ($this->Ruta->delete()) {
      $this->Session->setFlash(__('Eliminado!!'), 'msgbueno');
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('No se elemino'), 'msgalert');
    $this->redirect(array('action' => 'index'));
  }

  public function listadoclientes($idRuta = null) {

    $datosRuta = $this->Ruta->findById($idRuta, null, null, 0);
    //debug($datosRuta);die;
    if ($this->RequestHandler->responseType() == 'json') {
      
      //debug($idRuta);die;
      $editar = '<button class="button orange-gradient compact icon-pencil" type="button" onclick="editarc(' . "',Cliente.id,'" . ')">Editar</button>';
      $elimina = '<button class="button red-gradient compact icon-cross-round" type="button" onclick="eliminarc(' . "',Cliente.id,'" . ')">Eliminar</button>';
      $acciones = "$editar $elimina";
      $this->Cliente->virtualFields = array(
        'acciones' => "CONCAT('$acciones')"
      );
      $condiciones = array();
      
      /*if ($this->Session->read('Auth.User.Group.name') == 'Distribuidores') {
        $condiciones['Cliente.ruta_id'] = $this->Session->read('Auth.User.ruta_id');
      }*/
      $condiciones['Cliente.ruta_id'] = $idRuta;
      
      $this->paginate = array(
        'fields' => array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Cliente.zona', 'Cliente.acciones'),
        'recursive' => -1,
        'order' => 'Cliente.id DESC',
        'conditions' => $condiciones
      );
      $this->DataTable->fields = array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Cliente.zona', 'Cliente.acciones');

      $this->set('clientes', $this->DataTable->getResponse('Rutas', 'Cliente'));
      $this->set('_serialize', 'clientes');      
    }
    $this->set(compact('idRuta', 'datosRuta'));
  }

}
