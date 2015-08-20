<?php

class SucursalsController extends AppController {

  public $uses = array(
    'Sucursal', 'Group',
    'Clase',
    'Cabina',
    'Recargascabina',
    'Tiposproducto',
    'Producto',
    'Almacene',
    'User'
  );
  public $layout = 'viva';

  public function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  public function demo() {
    
  }

  public function index() {
    $sucursals = $this->Sucursal->find('all', array(
      'recursive' => 0,
    ));
    //debug($sucursals);exit;
    $this->set(compact('sucursals'));
  }

  public function insertar() {
    if (!empty($this->request->data)) {
      $this->Sucursal->create();
      if ($this->Sucursal->save($this->request->data)) {
        $id = $this->Sucursal->getLastInsertID();
        $d_alma['nombre'] = $this->request->data['Sucursal']['nombre'];
        $d_alma['sucursal_id'] = $id;
        $d_alma['central'] = 0;
        $this->Almacene->create();
        $this->Almacene->save($d_alma);
        $this->Session->setFlash('Tienda registrada con Exito...!!!', 'msgbueno');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Error al registrar', 'msgerror');
        $this->redirect(array('action' => 'insertar'));
      }
    }
  }

  public function addrecargacabina() {
    $categoria = $this->Tiposproducto->find('all', array('recursive' => -1));
    //debug($categoria);exit;
    if (!empty($this->request->data)) {
      $this->Recargascabina->create();
      //debug($this->request->data);exit;
      if ($this->Recargascabina->save($this->request->data)) {
        $this->Session->setFlash('Producto registrado con Exito...!!!', 'msgbueno');
        $this->redirect(array('action' => 'productos'));
      } else {
        $this->Session->setFlash('Error al registrar', 'msgerror');
        $this->redirect(array('action' => 'productos'));
      }
    }
    $this->set(compact('categoria'));
  }

  public function ajaxproductos($idcategoria = null) {
    $this->layout = 'ajax';
    $productos = $this->Producto->find('all', array('recursive' => 0, 'conditions' => array('Producto.tiposproducto_id' => $idcategoria)));
    //debug($productos);exit;
    $this->set(compact('productos'));
  }

  public function editapro($id = null) {
    $this->Recargascabina->id = $id;
    $nombre = $this->Recargascabina->find('first', array('conditions' => array('Recargascabina.id' => $id)));
    if (!$id) {
      $this->Session->setFlash('No existe el registro', 'msgerror');
      $this->redirect(array('action' => 'productos'), null, true);
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->Recargascabina->read(); //find(array('id' => $id));
    } else {

      if ($this->Recargascabina->save($this->request->data)) {
        $this->Session->setFlash('Los datos fueron modificados', 'msgbueno');
        $this->redirect(array('action' => 'productos'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!', 'msgerror');
      }
    }
    //debug($nombre);exit;
    $this->set(compact('nombre'));
  }

  public function productos() {
    $productos = $this->Recargascabina->find('all');
    $this->set(compact('productos'));
  }

  public function editar($id = null) {
    $this->Sucursal->id = $id;
    if (!$id) {
      $this->Session->setFlash('No existe el registro', 'msgerror');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->Sucursal->read(); //find(array('id' => $id));
    } else {
      if ($this->Sucursal->save($this->request->data)) {
        $almacen = $this->Almacene->findBysucursal_id($id,null,null,-1);
        $d_alma['nombre'] = $this->request->data['Sucursal']['nombre'];
        if(!empty($almacen)){
          $this->Almacene->id = $almacen['Almacene']['id'];
          $this->Almacene->save($d_alma);
        }else{
          $d_alma['sucursal_id'] = $id;
          $d_alma['central'] = 0;
          $this->Almacene->create();
          $this->Almacene->save($d_alma);
        }
        $this->Session->setFlash('Los datos fueron modificados', 'msgbueno');
        $this->redirect(array('action' => 'index'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!', 'msgerror');
      }
    }
  }

  function eliminapro($id = null) {
    $this->Recargascabina->id = $id;
    $this->request->data = $this->Recargascabina->read();
    if (!$id) {
      $this->Session->setFlash('No existe el registro a eliminar', 'msgerror');
      $this->redirect(array('action' => 'productos'));
    } else {
      if ($this->Recargascabina->delete($id)) {
        $this->Session->setFlash('Se elimino la tienda ' . $this->request->data['Tienda']['nombre'], 'msgbueno');
        $this->redirect(array('action' => 'productos'));
      } else {
        $this->Session->setFlash('Error al eliminar', 'msgerror');
      }
    }
  }

  function eliminar($id = null) {
    $this->Sucursal->id = $id;
    $this->request->data = $this->Sucursal->read();
    if (!$id) {
      $this->Session->setFlash('No existe el registro a eliminar', 'msgerror');
      $this->redirect(array('action' => 'index'));
    } else {
      if ($this->Sucursal->delete($id)) {
        $this->Session->setFlash('Se elimino la tienda ' . $this->request->data['Tienda']['nombre'], 'msgbueno');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Error al eliminar', 'msgerror');
      }
    }
  }

  public function ajaxverusuarios($idTienda = null) {
    $this->layout = 'ajax';
    $usuarios2 = $this->User->find('all', array(
      'conditions' => array('User.sucursal_id' => $idTienda,'User.group_id' => 5)
    ));
    //$g = $usuarios2['User']['username'];
    //debug($usuarios2);exit;
    $this->set(compact('usuarios2'));
  }

  public function usuarios($id = null) {
    $usuarios = $this->User->find('all', array(
      'conditions' => array('User.sucursal_id' => $id)));
    $this->set(compact('usuarios'));
  }

}

?>
