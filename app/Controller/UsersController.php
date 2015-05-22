<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

  public $uses = array('User', 'Migralmacen', 'Group', 'Persona', 'Sucursal','Lugare','Ruta');
  public $layout = 'viva';
  public $components = array('Acl', 'Auth');

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow();
  }

  public function login2() {
    if ($this->Session->read('Auth.User')) {
      $this->Session->setFlash('You are logged in!');
      $this->redirect('/', null, false);
    }
  }

  public function login() {

    $this->layout = 'login';

    if ($this->request->is('post')) {
      //debug($this->request->params);
      //debug($usuario.$pass);die;
      if ($this->Auth->login()) {
        //$this->redirect($this->Auth->redirect());
        $rol = $this->Session->read('Auth.User.group_id');
        switch ($rol) {
          case '1':$this->redirect(array('controller' => 'Users', 'action' => 'index'));
            break;
          case '2':$this->redirect(array('controller' => 'Ventasdistribuidor', 'action' => 'clientes'));
            break;
          case '3': $this->redirect(array('controller' => 'Almacenes', 'action' => 'listadistribuidores'));
            break;
          case '4':$this->redirect(array('controller' => 'Recargas', 'action' => 'listarecargas'));
            break;
          case '5': $this->redirect(array('controller' => 'Tiendas', 'action' => 'index'));
            break;
          default :$this->redirect(array('controller' => 'Tiendas', 'action' => 'index'));
            break;
        }
      } else {
        $this->Session->setFlash('Intente Nuevamente Porfavor.', 'msglogin');
      }
    }
  }

  public function index22() {

    $this->User->find('all', array(
      'recursive' => 0,
      'limit' => 50,
      'order' => 'User.id DESC'));
    //$this->User->find('all');
    $this->set('users', $this->paginate());
  }

  public function index() {

    $this->User->find('all');
    $this->set('users', $this->paginate());
  }

  public function ajaxver($idUsuario = null) {
    $this->layout = 'ajax';
    $usuario = $this->User->find('first', array('conditions' => array('User.id' => $idUsuario)));
    //debug($usuario);exit;
    $this->set(compact('usuario'));
  }

  /**
   * view method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function principal() {
    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
  }

  public function view($id = null) {
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid user'));
    }
    $this->set('user', $this->User->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if ($this->request->is('post')) {

      $this->User->create();

      $this->Persona->create();

      if ($this->Persona->save($this->request->data['Persona'])) {
        //debug($this->request->data);
        $iduser = $this->Persona->getLastInsertID();
        $this->request->data['User']['persona_id'] = $iduser;
        /* if ($this->request->data['User']['group_id'] == null){
          $this->Session->setFlash('Debe llenar el tipo de usuario..!!!!');
          $this->redirect(array('action' => 'add'));
          $this->Session->setFlash('Debe llenar el tipo de usuario..!!!!');
          } */

        if ($this->User->save($this->request->data['User'])) {
          $this->Session->setFlash(__('The user has been saved'));
          $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
      }
    }
    $tiendas = $this->Sucursal->find('all', array('recursive' => -1));
    $groups = $this->Group->find('all', array('recursive' => -1));
    $groups2 = $this->Group->find('list', array('fields' => array('Group.name')));
    $lugares = $this->Lugare->find('all', array('recursive'=>-1));
    $rutas = $this->Ruta->find('list', array('fields' => 'Ruta.nombre'));
    //debug($rutas); exit;
    $this->set(compact('groups', 'tiendas', 'groups2','lugares', 'rutas'));
  }

  public function insertar() {
    if ($this->request->is('post')) {

      $this->User->create();
      $this->Persona->create();

      $nombre = $this->request->data['User']['username'];
      //debug($nombre);exit;
      $buscaNombre = $this->User->find('first', array(
        'recursive' => -1,
        'conditions' => array(
          'User.username' => $nombre)));
      //debug($nombre);exit;


      if ($this->Persona->save($this->request->data['Persona'])) {
        //debug($this->request->data);
        $iduser = $this->Persona->getLastInsertID();
        $this->request->data['User']['persona_id'] = $iduser;
        if (empty($buscaNombre)) {
          $this->User->create();
          if ($this->User->save($this->request->data['User'])) {
            $this->Session->setFlash(__('The user has been saved'));
            $this->redirect(array('action' => 'index'));
          } else {
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
          }
        } else {
          $this->Session->setFlash('Ya existe ese usuario', 'msguser');
        }
      }
    }
    $tiendas = $this->Sucursal->find('all', array('recursive' => -1));
    $groups = $this->Group->find('all', array('recursive' => -1));
    $groups2 = $this->Group->find('list', array('fields' => array('Group.name')));
    
    $this->set(compact('groups', 'tiendas', 'groups2', 'rutas'));
  }

  public function salir() {
    //$this->Session->setFlash('Good-Bye');
    $this->redirect($this->Auth->logout());
    $this->redirect(array('controller' => 'Users', 'action' => 'login'));
  }

  //esta funcion ejecuta llenado de aros_acos
  public function initDB() {
    $group = $this->User->Group;
    //Allow admins to everything
    $group->id = 1;
    $this->Acl->allow($group, 'controllers');

    //allow managers to posts and widgets
    /* $group->id = 2;
      $this->Acl->deny($group, 'controllers');
      $this->Acl->allow($group, 'controllers/Posts');
      $this->Acl->allow($group, 'controllers/Widgets');

      //allow users to only add and edit on posts and widgets
      $group->id = 3;
      $this->Acl->deny($group, 'controllers');
      $this->Acl->allow($group, 'controllers/Posts/add');
      $this->Acl->allow($group, 'controllers/Posts/edit');
      $this->Acl->allow($group, 'controllers/Widgets/add');
      $this->Acl->allow($group, 'controllers/Widgets/edit'); */
    //we add an exit to avoid an ugly "missing views" error message
    echo "all done";
    exit;
  }

  /**
   * edit method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function edit($id = null) {

    $this->User->id = $id;
    if (!$id) {
      $this->Session->setFlash('No existe tal registro');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if (empty($this->request->data)) {
      $this->data = $this->User->read();
    } else {
      if ($this->User->save($this->data)) {
        $this->Session->setFlash('Los datos fueron modificados');
        $this->redirect(array('action' => 'index'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!');
      }
    }
    $groups = $this->User->Group->find('all', array('recursive' => -1));
    $tiendas = $this->Sucursal->find('all', array('recursive' => -1));
    $this->set(compact('groups', 'tiendas'));
  }

  function editar($id = null) {

    $this->User->id = $id;
    $idPersona = $this->User->find('first', array(
      'recursive' => -1,
      'conditions' => array('User.id' => $id)
    ));
    $this->Persona->id = $idPersona['User']['persona_id'];
    //debug($this->Persona->id);die;
    if (!$id) {
      $this->Session->setFlash('No existe tal registro', 'msgerror');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if (empty($this->request->data)) {
      $this->data = $this->User->read();
      $this->data = $this->Persona->read();
    } else {
      //debug($this->request->data);die;
      if ($this->Persona->save($this->request->data['Persona'])) {
        //$this->Session->setFlash('Los datos fueron modificados', 'msgbueno');
        if(!empty($this->request->data['User']['password2'])){
          $this->request->data['User']['password']=$this->request->data['User']['password2'];
        }
        if ($this->User->save($this->request->data['User'])) {
          $this->Session->setFlash('Los datos fueron modificados', 'msgbueno');
          $this->redirect(array('action' => 'index'), null, true);
        } else {
          $this->Session->setFlash('no se pudo modificar!!', 'msgerror');
        }
        //$this->redirect(array('action' => 'index'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!', 'msgerror');
      }
    }
    $groups = $this->User->Group->find('all', array('recursive' => -1));
    $tiendas = $this->Sucursal->find('all', array('recursive' => -1));
    $lugares =  $this->Lugare->find('all', array('recursive'=> -1));
    $rutas = $this->Ruta->find('list', array('fields' => 'Ruta.nombre'));
    $this->set(compact('groups', 'tiendas', 'lugares','rutas','idPersona'));
  }

  public function delete($id = null) {
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Usuario invalido'));
    }
    if ($this->User->delete()) {
      $this->Session->setFlash(__('Usuario eliminado'), 'msgbueno');
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('El usuario no se elemino'), 'msgalert');
    $this->redirect(array('action' => 'index'));
  }

  public function cambiopass($id = null) {
    $this->User->id = $id;
    if (!$id) {
      $this->Session->setFlash('No existe tal registro');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if (empty($this->data)) {
      $this->data = $this->User->read();
    } else {
      if ($this->User->save($this->data)) {
        $this->Session->setFlash('Su Password fue modificado Exitosamente');
        $this->redirect(array('action' => 'index'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!');
      }
    }
  }

  public function verificamoso() {
    $this->layout = 'mosos';

    $this->request->data['User']['username'] = 'moso';
    if ($this->request->is('post')) {
      if ($this->Auth->login()) {
        //$this->redirect($this->Auth->redirect());
        $this->redirect(array('controller' => 'Pedidos', 'action' => 'mesas'));
      } else {
        $this->Session->setFlash('Usuario o Password incorrectos.');
      }
    }

    /* if(!empty($this->request->data))
      {
      debug($this->request->data);exit;
      }else{

      } */
  }

}
