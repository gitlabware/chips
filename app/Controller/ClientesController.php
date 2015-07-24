<?php

App::uses('AppController', 'Controller');

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

class ClientesController extends AppController {

  public $uses = array('Cliente', 'Recarga', 'Lugare', 'Ruta', 'Rutasusuario', 'Excel');
  var $components = array('RequestHandler', 'DataTable');
  public $layout = 'viva';

  public function beforeFilter() {
    parent::beforeFilter();
    if ($this->RequestHandler->responseType() == 'json') {
      $this->RequestHandler->setContent('json', 'application/json');
    }
    //$this->Auth->allow();
  }

  public function index() {
    //$this->Cliente->recursive = 0;
    //$this->set('clientes', $this->paginate());
    //debug($clientes);exit;
    if ($this->RequestHandler->responseType() == 'json') {
      $editar = '<button class="button orange-gradient compact icon-pencil" type="button" onclick="editarc(' . "',Cliente.id,'" . ')">Editar</button>';
      $elimina = '<button class="button red-gradient compact icon-cross-round" type="button" onclick="eliminarc(' . "',Cliente.id,'" . ')">Eliminar</button>';
      $acciones = "$editar $elimina";
      $this->Cliente->virtualFields = array(
        'acciones' => "CONCAT('$acciones')"
      );
      $condiciones = array();
      if ($this->Session->read('Auth.User.Group.name') == 'Distribuidores') {
        $rutas_usuario = $this->Rutasusuario->find('list', array(
          'conditions' => array('Rutasusuario.user_id' => $this->Session->read('Auth.User.id')),
          'fields' => array('Rutasusuario.ruta_id')
        ));
        $condiciones['Cliente.ruta_id'] = $rutas_usuario;
      }
      $this->paginate = array(
        'fields' => array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Ruta.nombre', 'Cliente.zona', 'Cliente.acciones'),
        'recursive' => 0,
        'order' => 'Cliente.id DESC',
        'conditions' => $condiciones
      );
      $this->DataTable->fields = array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Ruta.nombre', 'Cliente.zona', 'Cliente.acciones');

      $this->set('clientes', $this->DataTable->getResponse());
      $this->set('_serialize', 'clientes');
    }
  }

  public function clientes() {
    $clientes = $this->Cliente->find('all', array('recursive' => -1));
    $this->set(compact('clientes'));
  }

  public function edit($id = null) {
    $this->Cliente->id = $id;
    if (!$this->Cliente->exists()) {
      throw new NotFoundException(__('Invalid cliente'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      //debug($this->request->data); exit;
      if ($this->Cliente->save($this->request->data)) {
        $this->Session->setFlash(__('The user has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->Cliente->read(null, $id);
    }
    $lugares = $this->Lugare->find('all', array('recursive' => -1));
    $rutas = $this->Ruta->find('list', array('fields' => 'Ruta.nombre'));
    $this->set(compact('lugares', 'rutas'));
    // $groups = $this->User->Group->find('all');
    //$this->set(compact('groups'));
  }

  public function insertar($idCliente = null) {
    if ($this->request->is('post')) {
      $this->Cliente->create();
      $this->request->data['Cliente']['estado'] = 1;
      if ($this->Cliente->save($this->request->data['Cliente'])) {
        $this->Session->setFlash('Se registro correctamente!!', 'msgbueno');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('No Se pudo registrar', 'msgerror');
      }
    }
    $lugares = $this->Lugare->find('list', array('recursive' => -1, 'fields' => 'Lugare.nombre'));
    $condiciones = array();
    if ($this->Session->read('Auth.User.Group.name') == 'Distribuidores') {
      $rutas_usuario = $this->Rutasusuario->find('list', array(
        'conditions' => array('Rutasusuario.user_id' => $this->Session->read('Auth.User.id')),
        'fields' => array('Rutasusuario.ruta_id')
      ));
      $condiciones['Ruta.id'] = $rutas_usuario;
    }
    $rutas = $this->Ruta->find('list', array('fields' => 'Ruta.nombre', 'conditions' => $condiciones));
    $this->Cliente->id = $idCliente;
    $this->request->data = $this->Cliente->read();
    $this->set(compact('lugares', 'rutas'));
    //$groups = $this->User->Group->find('all', array ('recursive'=>-1));
    //$this->set(compact('groups'));
  }

  public function delete($id = null) {
    $this->Cliente->id = $id;
    if (!$this->Cliente->exists()) {
      throw new NotFoundException(__('Usuario invalido'));
    }
    if ($this->Cliente->delete()) {
      $this->Session->setFlash(__('Cliente eliminado'), 'msgbueno');
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('El Cliente no se elemino'), 'msgalert');
    $this->redirect(array('action' => 'index'));
  }

  public function nuevarecarga() {
    if ($this->request->is('post')) {

      $this->Recarga->create();
      //debug($this->request->data); 

      if ($this->Recarga->save($this->request->data['Recarga'])) {

        //debug($iduser);exit;

        $this->Session->setFlash(__('The user has been saved'));

        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
      }
    }

    //$groups = $this->User->Group->find('all', array ('recursive'=>-1));
    //  $this->set(compact('groups'));
  }

  public function guardaexcel() {
    //debug($this->request->data);die;
    $archivoExcel = $this->request->data['Excel']['excel'];
    $nombreOriginal = $this->request->data['Excel']['excel']['name'];

    if ($archivoExcel['error'] === UPLOAD_ERR_OK) {
      $nombre = string::uuid();
      if (move_uploaded_file($archivoExcel['tmp_name'], WWW_ROOT . 'files' . DS . $nombre . '.xlsx')) {
        $nombreExcel = $nombre . '.xlsx';
        $direccionExcel = WWW_ROOT . 'files';
        $this->request->data['Excelg']['nombre'] = $nombreExcel;
        $this->request->data['Excelg']['nombre_original'] = $nombreOriginal;
        $this->request->data['Excelg']['direccion'] = "";
        $this->request->data['Excelg']['tipo'] = "asignacion";
      }
    }

    if ($this->Excel->save($this->data['Excelg'])) {
      $ultimoExcel = $this->Excel->getLastInsertID();
      //debug($ultimoExcel);die;
      $excelSubido = $nombreExcel;
      $objLector = new PHPExcel_Reader_Excel2007();
      //debug($objLector);die;
      $objPHPExcel = $objLector->load("../webroot/files/$excelSubido");
      //debug($objPHPExcel);die;

      $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();

      $array_data = array();

      foreach ($rowIterator as $row) {
        $cellIterator = $row->getCellIterator();

        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

        if ($row->getRowIndex() >= 3) { //a partir de la 1
          $rowIndex = $row->getRowIndex();

          $array_data[$rowIndex] = array(
            'A' => '',
            'B' => '',
            'C' => '',
            'D' => '',
            'E' => '',
            'F' => '',
            'G' => '',
            'H' => '',
            'I' => '');

          foreach ($cellIterator as $cell) {
            if ('A' == $cell->getColumn()) {
              $dato_a = $cell->getCalculatedValue();
              $cliente = $this->Cliente->find('first', array(
                'recursive' => -1,
                'conditions' => array('Cliente.num_registro' => $dato_a),
                'fields' => array('Cliente.id')));
              if (!empty($cliente)) {
                $this->Session->setFlash("El clieente con numero de registro: $dato_a ya esta registrado!!", 'msgerror');
                $this->redirect($this->referer());
              }
              $array_data[$rowIndex][$cell->getColumn()] = $dato_a;
            } elseif ('B' == $cell->getColumn()) {
              $dato_b = $cell->getCalculatedValue();
              $cliente = $this->Cliente->find('first', array('recursive' => -1, 'conditions' => array('Cliente.num_registro' => $dato_b), 'fields' => array('Cliente.id')));
              if (!empty($cliente)) {
                $this->Session->setFlash("El cliente con codigo: $dato_b ya esta registrado!!", 'msgerror');
                $this->redirect($this->referer());
              }
              $array_data[$rowIndex][$cell->getColumn()] = $dato_b;
            } elseif ('C' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('D' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('E' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('F' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('G' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('H' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('I' == $cell->getColumn()) {
              $dato_i = $cell->getCalculatedValue();
              $idRuta = NULL;
              if (!empty($dato_i)) {
                $ruta = $this->Ruta->findBycod_ruta($dato_i, null, null, -1);
                if (!empty($ruta)) {
                  $idRuta = $ruta['Ruta']['id'];
                } else {
                  $this->Ruta->create();
                  $dato_ruta['cod_ruta'] = $dato_i;
                  $dato_ruta['nombre'] = $dato_i;
                  $this->Ruta->save($dato_ruta);
                  $idRuta = $this->Ruta->getLastInsertID();
                }
              }
              $array_data[$rowIndex][$cell->getColumn()] = $idRuta;
            }
          }
        }
      }
      $this->request->data = "";
      foreach ($array_data as $d) {
        $this->request->data['Cliente']['num_registro'] = $d['A'];
        $this->request->data['Cliente']['cod_dealer'] = $d['B'];
        $this->request->data['Cliente']['nombre'] = $d['C'];
        $this->request->data['Cliente']['direccion'] = $d['D'];
        $this->request->data['Cliente']['celular'] = $d['E'];
        $this->request->data['Cliente']['zona'] = $d['F'];
        $this->request->data['Cliente']['cod_mercado'] = $d['G'];
        $this->request->data['Cliente']['mercado'] = $d['H'];
        $this->request->data['Cliente']['ruta_id'] = $d['I'];
        $this->Cliente->create();
        $this->Cliente->save($this->request->data['Cliente']);
      }
      $this->Session->setFlash("Se registro correctamente!!!", 'msgbueno');
      $this->redirect($this->referer());
      //fin funciones del excel
    } else {
      $this->Session->setFlash("No se pudo registrar", 'msgerror');
      $this->redirect($this->referer());
      //echo 'no';
    }
  }

}

?>