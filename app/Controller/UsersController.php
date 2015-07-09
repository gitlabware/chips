<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

  public $uses = array('User', 'Migralmacen', 'Group', 'Persona', 'Sucursal', 'Lugare', 'Ruta', 'Rutasusuario', 'Precio');
  public $layout = 'viva';
  public $components = array('Acl', 'Auth', 'RequestHandler');

  public function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  function respond($message = null, $json = false) {

    if ($message != null) {
      if ($json == true) {
        $this->RequestHandler->setContent('json', 'application/json');
        $message = json_encode($message);
      }
      $this->set('message', $message);
    }
    $this->render('message');
    //$this->render = false;
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
          case '1':$this->redirect(array('controller' => 'Almacenes', 'action' => 'principal'));
            break;
          case '2':$this->redirect(array('controller' => 'Ventasdistribuidor', 'action' => 'clientes'));
            break;
          case '3': $this->redirect(array('controller' => 'Almacenes', 'action' => 'listadistribuidores'));
            break;
          case '4':$this->redirect(array('controller' => 'Recargados', 'action' => 'nuevo'));
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
    $users = $this->User->find('all', array('order' => array('User.estado', 'User.id DESC')));
    $this->set(compact('users'));
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
      //debug($this->request->data);die;
      $ruta = $this->request->data['User']['ruta_id'];
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
        $this->request->data['User']['estado'] = 'Activo';
        if ($this->User->save($this->request->data['User'])) {

          if ($this->request->data['User']['group_id'] == 2) {

            $idUser = $this->User->getLastInsertID();
            $this->Rutasusuario->create();
            $this->request->data['Rutasusuario']['user_id'] = $idUser;
            $this->request->data['Rutasusuario']['ruta_id'] = $ruta;
            if ($this->Rutasusuario->save($this->request->data['Rutasusuario'])) {
              $this->Session->setFlash(__('The user has been saved'));
              $this->redirect(array('action' => 'index'));
            }
          }

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
    $lugares = $this->Lugare->find('all', array('recursive' => -1));
    $rutas = $this->Ruta->find('list', array('fields' => 'Ruta.nombre'));
    $lugares_list = $this->Lugare->find('list', array('fields' => array('Nombre', 'Nombre')));
    //debug($rutas); exit;
    $this->set(compact('groups', 'tiendas', 'groups2', 'lugares', 'rutas', 'lugares_list'));
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

      $this->data = $this->Persona->read();
      $this->data = $this->User->read();
    } else {
      //debug($this->request->data);die;
      if ($this->Persona->save($this->request->data['Persona'])) {
        //$this->Session->setFlash('Los datos fueron modificados', 'msgbueno');
        if (!empty($this->request->data['User']['password2'])) {
          $this->request->data['User']['password'] = $this->request->data['User']['password2'];
        }
        if ($this->User->save($this->request->data['User'])) {
          $this->Session->setFlash('Los datos fueron modificados', 'msgbueno');
          if ($this->Session->read('Auth.User.group_id') == 1) {
            $this->redirect(array('action' => 'index'), null, true);
          } else {
            $this->redirect($this->referer());
          }
        } else {
          $this->Session->setFlash('no se pudo modificar!!', 'msgerror');
        }
        //$this->redirect(array('action' => 'index'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!', 'msgerror');
      }
    }
    $groups = $this->User->Group->find('list', array('recursive' => -1, 'fields' => 'name'));
    $tiendas = $this->Sucursal->find('list', array('recursive' => -1, 'fields' => 'nombre'));
    $lugares = $this->Lugare->find('list', array('recursive' => -1, 'fields' => 'Lugare.nombre'));
    $rutas = $this->Ruta->find('list', array('fields' => 'Ruta.nombre'));
    $lugares_list = $this->Lugare->find('list', array('fields' => array('Nombre', 'Nombre')));
    //debug($this->request->data);exit;
    $this->set(compact('groups', 'tiendas', 'lugares', 'rutas', 'idPersona', 'lugares_list'));
  }

  public function delete($id = null) {

    $idUsuario = $this->User->findById($id, null, null, -1);
    $Persona = $this->Persona->findById($idUsuario['User']['persona_id'], null, null, -1);
    $idPersona = $Persona['Persona']['id'];
    //debug($idPersona);die;
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Usuario invalido'));
    }
    if ($this->User->delete()) {
      if ($this->Persona->delete($idPersona)) {
        $this->Session->setFlash(__('Usuario eliminado'), 'msgbueno');
        $this->redirect(array('action' => 'index'));
      }
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

  public function ajaxrutas($idUsuario = null) {
    $this->layout = 'ajax';
    $rutasUsuario = $this->Rutasusuario->find('all', array(
      'recursive' => 0,
      'conditions' => array('Rutasusuario.user_id' => $idUsuario)
    ));
    $csr = $this->Ruta->find('list', array(
      'fields' => array('Ruta.id', 'Ruta.nombre')
    ));
    //debug($rutas);
    $this->set(compact('rutasUsuario', 'csr', 'idUsuario'));
  }

  public function registraruta() {
    //debug($this->request->data);
    $array['correcto'] = '';
    if (!empty($this->request->data)) {
      $this->Rutasusuario->create();
      if ($this->Rutasusuario->save($this->request->data['User'])) {
        $array['correcto'] = 'Se registro correctamente!!!';
      }
    }
    $this->respond($array, true);
  }

  public function quita_ruta($idRuta = null) {
    //debug($idRuta);
    $array['correcto'] = '';
    if ($this->Rutasusuario->delete($idRuta)) {
      $array['correcto'] = 'Se quito el precio correctamente!!!';
    }
    $this->respond($array, true);
    //$this->redirect(array('action' => 'ajax_precios',$idProducto));
  }

  public function ajaxprecios() {
    $precios = $this->Precio->find('all');
    $this->set(compact('precios'));
  }

  public function registra_precios() {
    $dat = $this->request->data['Precio'];
    $this->Precio->saveAll($dat);
    $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
    $this->redirect($this->referer());
  }

}
