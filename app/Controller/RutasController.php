<?php

class Rutascontroller extends AppController {

  public $layout = 'viva';
  public $uses = array('Ruta', 'Cliente', 'Meta');
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

      /* if ($this->Session->read('Auth.User.Group.name') == 'Distribuidores') {
        $condiciones['Cliente.ruta_id'] = $this->Session->read('Auth.User.ruta_id');
        } */
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

  public function listadometasmes() {

    $metas = $this->Meta->find('all', array(
      'recursive' => -1,
      'group' => array('Meta.mes', 'Meta.anyo', 'DATE(Meta.created)'),
      'fields' => array('Meta.anyo', 'DATE(Meta.created) AS creado', 'SUM(Meta.meta) as total', 'Meta.mes'),
      'order' => array('Meta.created DESC')
    ));
    $this->set(compact('metas'));
  }

  public function metas($ano = null, $mes = null) {

    $this->layout = 'ajax';

    if (!empty($this->request->data)) {
      $this->Meta->deleteAll(array('Meta.anyo' => $ano,'Meta.mes' => $mes));
      foreach ($this->request->data['Metas'] as $me) {
        $_dme = $me;
        $_dme['mes'] = $this->request->data['Meta']['mes'];
        $_dme['anyo'] = $this->request->data['Meta']['anyo']['year'];
        $this->Meta->create();
        $this->Meta->save($_dme);
      }
      $this->Session->setFlash("Se ha registrado correctamente las metas!!", 'msgbueno');
      $this->redirect($this->referer());
    }
    if (!empty($ano) && !empty($mes)) {
      $rutas = $this->Meta->find('all', array(
        'recursive' => 0,
        'conditions' => array('Meta.anyo' => $ano, 'Meta.mes' => $mes)
      ));
    } else {
      $rutas = $this->Ruta->find('all', array(
        'recursive' => 0,
        'conditions' => array('!ISNULL(Ruta.cod_ruta)', 'Ruta.cod_ruta <>' => '')
      ));
    }

    $this->set(compact('rutas','ano','mes'));

    //debug($rutas);exit;
  }

  public function vermetas($ano = NULL, $mes = NULL) {
    $this->layout = 'ajax';
    $sql1 = "(SELECT COUNT(activados.id) FROM activados WHERE YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";
    $sql2 = "(SELECT COUNT(activados.id) FROM activados WHERE YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta AND activados.comercial LIKE 'SI' GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";
    
    $this->Meta->virtualFields = array(
      'ventas' => "($sql1)",
      'comercial' => "$sql2"
    );
    
    $metas = $this->Meta->find('all', array(
      'recursive' => 0,
      'conditions' => array('Meta.anyo' => $ano, 'Meta.mes' => $mes)
    ));
    
    //$sql_p = "(SELECT COUNT(activados.id) FROM activados WHERE YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = 3502 GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";
    //debug($this->Meta->query($sql_p));exit;
    $this->set(compact('metas', 'ano', 'mes'));
  }
  
  public function eliminametas($ano = NULL, $mes = NULL){
    if(!empty($ano) && !empty($mes)){
      $this->Meta->deleteAll(array('Meta.anyo' => $ano,'Meta.mes' => $mes));
      $this->Session->setFlash("Se ha eliminado correctamente las metas!!",'msgbueno');
      
    }
    $this->redirect($this->referer());
    
  }

}
