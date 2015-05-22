
<?php

App::uses('AppController', 'Controller');

/**
 * Almacenes Controller
 *
 * @property Almacene $Almacene
 */
class AlmacenesController extends AppController {

  public $uses = array('Almacene', 'Tiposproducto', 'Persona', 'Producto', 'Movimiento', 'Detalle', 'User', 'Deposito', 'Movimientosrecarga', 'Sucursal', 'Banco', 'Ventascelulare');
  public $components = array('Session', 'Fechasconvert', 'RequestHandler', 'DataTable');
  public $layout = 'viva';

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow();
  }

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $almacenes = $this->Almacene->find('all');
    $this->set(compact('almacenes'));
  }

  /**
   * view method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function view($id = null) {
    $this->Almacene->id = $id;
    if (!$this->Almacene->exists()) {
      throw new NotFoundException(__('Invalid almacene'));
    }
    $this->set('almacene', $this->Almacene->read(null, $id));
  }

  /**
   * add method
   *
   * @return void
   */
  public function add() {
    
    if ($this->request->is('post')) {
      $this->Almacene->create();
      $this->request->data['Almacene']['central'] = 0;
      if ($this->Almacene->save($this->request->data)) {
        $this->Session->setFlash(__('The almacene has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The almacene could not be saved. Please, try again.'));
      }
    }

    $sucursals = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('sucursals'));
  }

  /**
   * edit method
   *
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  public function editar($id = null) {
    $this->Almacene->id = $id;
    if (!$this->Almacene->exists()) {
      throw new NotFoundException(__('Invalid almacene'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Almacene->save($this->request->data)) {
        $this->Session->setFlash(__('The almacene has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The almacene could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->Almacene->read(null, $id);
    }
    $sucursals = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('sucursals'));
  }

  /**
   * delete method
   *
   * @throws MethodNotAllowedException
   * @throws NotFoundException
   * @param string $id
   * @return void
   */
  function eliminar($id = null) {
    $this->Almacene->id = $id;
    $this->request->data = $this->Almacene->read();
    if (!$id) {
      $this->Session->setFlash('No existe el registro a eliminar', 'msgerror');
      $this->redirect(array('action' => 'index'));
    } else {
      if ($this->Almacene->delete($id)) {
        $this->Session->setFlash('Se elimino el almacen' . $this->request->data['Tienda']['nombre'], 'msgbueno');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Error al eliminar', 'msgerror');
      }
    }
  }

  /**
   * entregas normales desde almacen method
   * */
  public function listadistribuidores() {
    $distribuidores = $this->User->find('all', array(
      'conditions' => array('User.group_id' => '2')
      )
    );
    $this->set(compact('distribuidores'));
  }

  public function listaalmacenes() {
    $distribuidores = $this->Almacene->find('all');
    $this->set(compact('distribuidores'));
  }

  public function listaentregas($idPersona = null, $almacen = null) {

    if ($almacen == 1) {
      $persona = $this->Almacene->find('first', array('conditions' => array('Almacene.id' => $idPersona)));
      $nombre = $persona['Almacene']['nombre'];
      $ultimosId = $this->Movimiento->find(
        'all', array(
        'fields' => array('MAX(Movimiento.id) as ultimo'),
        'conditions' => array('Movimiento.almacene_id' => $persona['Almacene']['id']),
        'group' => array('Movimiento.producto_id'),
        'order' => array('Movimiento.id DESC')
      ));
    } else {
      $persona = $this->Persona->find('first', array('conditions' => array('Persona.id' => $idPersona)));
      $nombre = $persona['Persona']['ap_paterno'] . ' ' . $persona['Persona']['ap_materno'] . ' ' . $persona['Persona']['nombre'];
      $ultimosId = $this->Movimiento->find(
        'all', array(
        'fields' => array('MAX(Movimiento.id) as ultimo'),
        'conditions' => array('Movimiento.persona_id' => $idPersona),
        'group' => array('Movimiento.producto_id'),
        'order' => array('Movimiento.id DESC')
      ));
    }

    $c = 0;
    $ides = array();
    foreach ($ultimosId as $ids) {
      $ides[$c] = $ids[0]['ultimo'];
      $c++;
    }

    $entregas = $this->Movimiento->find(
      'all', array(
      'fields' => array(
        'Movimiento.id',
        'Movimiento.saldo',
        'Movimiento.total',
        'Movimiento.producto_id',
        'Producto.nombre',
        'Producto.proveedor',
        'Producto.tiposproducto_id'),
      'conditions' => array(
        'Movimiento.id' => $ides
      ),
      'group' => array('Movimiento.producto_id')
      )
    );

    $this->set(compact('entregas', 'idPersona', 'nombre', 'almacen'));
  }

  public function ajaxrepartir($idPersona = null, $almacen = null) {
    $cen = $this->Almacene->find('first', array('conditions' => array('Almacene.id' => $idPersona)));
    $cent = $cen['Almacene']['central'];

    $this->layout = 'ajax';
    $categorias = $this->Tiposproducto->find('all', array('recursive' => -1));
    $productos = $this->Producto->find('all', array('recursive' => 0));

    if (!empty($this->request->data)) {
      /* debug($idPersona);
        debug($almacen);
        debug($this->request->data);
        exit; */
      $idProducto = $this->request->data['Movimiento']['producto_id'];
      $cantidad = $this->request->data['Movimiento']['ingreso'];
      $producto = $this->Producto->find('first', array('conditions' => array('Producto.id' => $idProducto)));
      $productoNombre = $producto['Producto']['nombre'];

      $idAlmacenCentral = $this->Almacene->find('first', array(
        'conditions' => array('Almacene.central' => true)));

      $idAlmacenCentral = $idAlmacenCentral['Almacene']['id'];
      /* corresponde al ultimo movimiento del producto en almacen central */
      $movimiento = $this->Movimiento->find('first', array(
        'conditions' => array('Movimiento.almacene_id' => $idAlmacenCentral,
          'Movimiento.producto_id' => $idProducto),
        'order' => array('Movimiento.id DESC'),
        'recursive' => -1
      ));
      $fecha = date('Y-m-d');
      /* fin movimiento almacen central */
      if (!empty($movimiento)) {
        $totalProducto = $movimiento['Movimiento']['total'];
      } else {
        $totalProducto = 0;
      }

      if ($almacen) {
        if ($idAlmacenCentral == $idPersona) {
          $almacenCentral = true;
        } else {
          $almacenCentral = false;
        }

        /* movimiento del almacen */
        $ultimoMovimiento = $this->Movimiento->find('first', array(
          'conditions' => array(
            'Movimiento.almacene_id' => $idPersona,
            'Movimiento.producto_id' => $idProducto),
          'order' => array('Movimiento.id DESC')
        ));
        /* fin del movimiento del almacen */

        if (!empty($ultimoMovimiento)) {

          if ($almacenCentral) {
            $total = $cantidad + $ultimoMovimiento['Movimiento']['total'];
            $ingreso = $cantidad;
          } else {//para otro almacenes de las tiendas
            //movimiento es la consulta de datos desde almacen central
            if (!empty($movimiento)) {
              if ($movimiento['Movimiento']['total'] == 0) {
                $this->Session->setFlash("Error en el registro de entrega'!!!...No existe $productoNombre en almacen central", 'msgerror');
                $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
              }
            } else {
              $this->Session->setFlash("Error en el registro de entrega'!!!...No existe $productoNombre en almacen central", 'msgerror');
              $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
            }
            $total = $cantidad + $ultimoMovimiento['Movimiento']['total'];
            $ingreso = $cantidad;
          }
        } else {//en caso de ser el primer registro de entrega para el almacen
          if ($almacenCentral) {

            $total = $cantidad;
            $saldo = 0;
            $ingreso = $cantidad;
          } else {
            if (!empty($movimiento)) {

              if ($totalProducto == 0) {
                $this->Session->setFlash("Error en el registro de entrega'!!!...No existe $productoNombre en almacen central", 'msgerror');
                $this->redirect(array('action' => 'listaentregas', $idPersona));
              }
            } else {
              $this->Session->setFlash("Error en el registro de entrega'!!!...No existe $productoNombre en almacen central", 'msgerror');
              $this->redirect(array('action' => 'listaentregas', $idPersona));
            }
            $total = $total + $cantidad;
            $saldo = 0;
            $ingreso = $cantidad;
          }
        }
      } else {//caso de no ser almacen
        $almacenCentral = false;

        $ultimoMovimiento = $this->Movimiento->find('first', array(
          'conditions' => array(
            'Movimiento.persona_id' => $idPersona,
            'Movimiento.producto_id' => $idProducto),
          'order' => array('Movimiento.id DESC')
        ));

        if (!empty($movimiento)) {

          if ($totalProducto == 0) {
            $this->Session->setFlash("Error en el registro de entrega'!!!...No existe $productoNombre en almacen central", 'msgerror');
            $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
          }
        } else {
          $this->Session->setFlash("Error en el registro de entrega'!!!...No existe $productoNombre en almacen central", 'msgerror');
          $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
        }

        if (!empty($ultimoMovimiento)) {
          $total = $ultimoMovimiento['Movimiento']['total'] + $cantidad;
          $ingreso = $cantidad;
        } else {
          $total = $cantidad;
          $ingreso = $cantidad;
        }
      }
      if ($almacen) {
        $almacen_d = $this->Almacene->findByid($idPersona, null, null, -1);
        $id_sucursal = $almacen_d['Almacene']['sucursal_id'];
        $this->request->data['Movimiento']['sucursal_id'] = $id_sucursal;
      }

      $this->request->data['Movimiento']['total'] = $total;
      $this->request->data['Movimiento']['ingreso'] = $ingreso;
      $this->request->data['Movimiento']['user_id'] = $this->Session->read("Auth.User.id");

      if ($this->request->data['Movimiento']['categoria'] == 1) {
        $this->request->data['Detalle']['producto_id'] = $idProducto;
        $this->request->data['Detalle']['cantient'] = $cantidad;
        if ($almacen) {
          $this->request->data['Detalle']['almacene_id'] = $idPersona;
        } else {
          $this->request->data['Detalle']['persona_id'] = $idPersona;
        }
      }

      if (!$almacenCentral && $cantidad > $totalProducto) {

        $this->Session->setFlash("Error en el registro de entrega'!!!...No existen suficientes $productoNombre en almacen central le quedan $totalProducto", 'msgerror');
        $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
      }

      $this->Movimiento->create();
      //debug($this->request->data);exit;//prueba para el registro de la entrega
      if ($this->Movimiento->save($this->request->data)) {

        $a = 0;
        $IdMovimiento = $this->Movimiento->getLastInsertID();

        if ($this->request->data['Movimiento']['categoria'] == 1) {
          $this->request->data['Detalle']['movimiento_id'] = $IdMovimiento;

          $this->Detalle->create();

          if ($this->Detalle->save($this->request->data['Detalle'])) {
            $a = 1;
          }

          if ($a == 0) {
            $this->Movimiento->delete($IdMovimiento);
            $this->Session->setFlash("Error en el registro de entrega'!!!", 'msgerror');
            $this->redirect(array('action' => 'listaentregas', $idPersona));
          }
        }

        if (!$almacenCentral) {
          $this->request->data = "";
          $totala = $totalProducto - $cantidad;
          $almacen_d = $this->Almacene->findByid($idAlmacenCentral, null, null, -1);
          $id_sucursal = $almacen_d['Almacene']['sucursal_id'];
          $this->request->data['Movimiento']['sucursal_id'] = $id_sucursal;
          $this->request->data['Movimiento']['almacene_id'] = $idAlmacenCentral;
          $this->request->data['Movimiento']['producto_id'] = $idProducto;
          $this->request->data['Movimiento']['total'] = $totala;
          $this->request->data['Movimiento']['salida'] = $cantidad;
          $this->request->data['Movimiento']['ingreso'] = 0;


          $this->Movimiento->create();
          if ($this->Movimiento->save($this->request->data)) {
            $this->Session->setFlash("se registro la entrega'!!!", 'msgbueno');
            $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
          } else {

            $this->Movimiento->delete($IdMovimiento);
            $this->Detalle->deleteAll(array('Detalle.movimiento_id' => $IdMovimiento));
            $this->Session->setFlash("Error en el registro de entrega'!!!", 'msgerror');
            $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
          }
        } else {
          $this->Session->setFlash("se registro el ingreso en almacen'!!!", 'msgbueno');
          $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
        }
      } else {
        $this->Session->setFlash("Error en el registro de entrega'!!!", 'msgerror');
        $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
      }
    }
    $this->set(compact('distribuidores', 'categorias', 'productos', 'idPersona', 'almacen', 'cent'));
  }

  public function ajaxproductos($idCategoria = null, $almacen = null) {
    $this->layout = 'ajax';
    $productos = $this->Producto->find('all', array(
      'conditions' => array('Producto.tiposproducto_id' => $idCategoria),
      'recursive' => 0));
    //debug($productos);exit;
    $this->set(compact('productos', 'almacen'));
  }

  public function ajaxcantidad($idProducto = null, $almacen = null) {
    //debug($almacen);exit;
    $this->layout = 'ajax';
    $producto = $this->Movimiento->find('first', array(
      'conditions' => array('Movimiento.almacene_id' => 1, 'Movimiento.producto_id' => $idProducto),
      'order' => array('Movimiento.id DESC'),
      'recursive' => -1
    ));
    //debug($producto);exit;
    $cantidad = $producto['Movimiento']['total'];
    //debug($cantidad);exit;
    $this->set(compact('cantidad', 'almacen'));
  }

  public function verdetalle($idPersona = null, $almacen = null, $idProducto = null) {
    if ($almacen) {



      $detalle = $this->Detalle->find('all', array('conditions' => array(
          'Detalle.almacene_id' => $idPersona,
          'Detalle.producto_id ' => $idProducto)));
      $nombre = $detalle[0]['Almacene']['nombre'];
    } else {

      $detalle = $this->Detalle->find('all', array('conditions' => array(
          'Detalle.persona_id' => $idPersona,
          'Detalle.producto_id ' => $idProducto)));
      $nombre = $detalle[0]['Persona']['ap_paterno'] . ' ' . $detalle[0]['Persona']['ap_paterno'] . ' ' . $detalle[0]['Persona']['nombre'];
    }
    $this->set(compact('detalle', 'nombre'));
  }

  public function verentregas($idPersona = null, $almacen = null, $idProducto = null) {
    if ($almacen) {
      $movimiento = $this->Movimiento->find('all', array(
        'conditions' => array(
          'Movimiento.almacene_id' => $idPersona,
          'Movimiento.producto_id' => $idProducto)
      ));
    } else {
      $movimiento = $this->Movimiento->find('all', array(
        'conditions' => array(
          'Movimiento.persona_id' => $idPersona,
          'Movimiento.producto_id' => $idProducto)
      ));
    }
  }

  public function productos() {
    $productos = $this->Movimiento->find('all', array(
      'fields' => array('MAX(Movimiento.id) as ultimo'),
      'order' => array('Movimiento.id DESC'),
      'group' => array('Movimiento.producto_id'),
      'recursive' => -1
    ));
    foreach ($productos as $producto) {
      
    }
    debug($productos);
    $this->set(compact('productos'));
  }

  public function filtra() {
    //$personas = $this->Persona->find('all');
    $personas = $this->User->find('all', array(
      'conditions' => array('User.group_id' => '2'),
      'recursive' => 0));
    $almacenes = $this->Almacene->find('all', array('recursive' => -1));
    $productos = $this->Producto->find('all', array('recursive' => -1));
    $this->set(compact('personas', 'almacenes', 'productos'));
  }

  public function reporteentrega() {
    //debug($this->request->data);exit;
    $idpersona = $this->request->data['Persona']['id'];
    $idalmacen = $this->request->data['Persona']['almacene_id'];
    $fecha = $this->request->data['Persona']['fecha'];
    $date = $this->Fechasconvert->doFormatdia($fecha);
    $almacentral = 0;
    $producto = $this->request->data['Persona']['producto_id'];
    $dato = '';
    //debug($idpersona);exit;
    if (!empty($idpersona)) {

      $movimiento = $this->Movimiento->find('first', array('order' => 'Movimiento.id DESC', 'conditions' => array('Movimiento.persona_id' => $idpersona, 'Movimiento.producto_id' => $producto, 'Movimiento.created' => $fecha)));
    }
    if (!empty($idalmacen)) {
      $movimiento = $this->Movimiento->find('first', array('order' => 'Movimiento.id DESC', 'conditions' => array('Movimiento.almacene_id' => $idalmacen, 'Movimiento.producto_id' => $producto, 'Movimiento.created' => $fecha)));
      $almacentral2 = $this->Almacene->find('first', array('conditions' => array('Almacene.id' => $idalmacen)));
      $almacentral = $almacentral2['Almacene']['central'];
    }


    $this->set(compact('datos', 'dato', 'fecha', 'almacentral', 'idalmacen', 'idpersona', 'producto', 'nombreproducto', 'movimiento'));
  }

  public function reporteentregas() {
    //$personas = $this->Persona->find('all');
    if (!empty($this->request->data)) {
      debug($this->request->data);
      exit;
    }
  }

  public function deposito() {
    if (!empty($this->request->data)) {
      //debug($this->request->data);exit;
      $this->Deposito->create();
      if ($this->Deposito->save($this->request->data)) {
        $this->Session->setFlash('Deposito registrado con exito', 'msgbueno');
        $this->redirect(array('action' => 'listadepositos'));
      } else {
        $this->Session->setFlash('Error al registrar intente de nuevo', 'msgerror');
        $this->redirect(array('action' => 'deposito'));
      }
    }
    $distribuidores = $this->User->find('all', array(
      'conditions' => array('User.group_id' => '2')
    ));
    $bancos = $this->Banco->find('list', array('fields' => 'nombre'));
    $this->set(compact('distribuidores', 'bancos'));
  }

  public function listadepositos() {
    //debug(''); exit;
    if ($this->Session->read('Auth.User.Group.name') == 'Administradores') {
      $depositos = $this->Deposito->find('all', array('oder' => 'Deposito.id ASC'));
    } else {
      $depositos = $this->Deposito->find('all', array('oder' => 'Deposito.id ASC', 'conditions' => array('Deposito.user_id' => $this->Session->read('Auth.User.id'))));
    }
    $this->set(compact('depositos'));
  }

  public function registrarecarga() {
    if (!empty($this->request->data)) {
      $recarga = $this->Movimientosrecarga->find('first', array('order' => array('Movimientosrecarga.id DESC')));
      if (!empty($recarga)) {
        if ($recarga['Movimientosrecarga']['fecha'] == $this->request->data['Movimientosrecarga']['fecha']) {
          $saldo = $recarga['Movimientosrecarga']['saldo'] + $this->request->data['Movimientosrecarga']['ingreso'];
          $this->request->data['Movimientosrecarga']['saldo_total'] = $this->request->data['Movimientosrecarga']['ingreso'] + $recarga['Movimientosrecarga']['saldo_total'];
          $this->request->data['Movimientosrecarga']['ingreso'] = $recarga['Movimientosrecarga']['ingreso'] + $this->request->data['Movimientosrecarga']['ingreso'];
        } else {
          $saldo = $recarga['Movimientosrecarga']['saldo'];
          $this->request->data['Movimientosrecarga']['saldo_total'] = $this->request->data['Movimientosrecarga']['ingreso'] + $recarga['Movimientosrecarga']['saldo_total'];
        }
      } else {
        $saldo = $this->request->data['Movimientosrecarga']['ingreso'];
        $this->request->data['Movimientosrecarga']['saldo_total'] = $saldo;
      }
      $this->request->data['Movimientosrecarga']['saldo'] = $saldo;

      if ($this->Movimientosrecarga->save($this->request->data)) {
        $this->Session->setFlash('recarga registrada', 'msgbueno');
        $this->redirect(array('action' => 'estadorecargas'));
      } else {
        $this->Session->setFlash('Error en el registro de la recarga', 'msgerror');
        $this->redirect(array('action' => 'registrarecarga'));
      }
    }
  }

  public function estadorecargas() {
    $this->layout = 'modal';
    $recarga = $this->Movimientosrecarga->find('first', array('order' => array('Movimientosrecarga.id DESC')));
    $this->set(compact('recarga'));
  }

  public function entrega_celulares($id_a = null, $es_almacen = NULL) {
    $cond_sql = '';
    $almacen = array();
    if ($es_almacen == 1) {
      $cond_sql = "AND v.almacene_id = $id_a";
      $almacen = $this->Almacene->find('first', array('fields' => array('Sucursal.nombre'), 'conditions' => array('Almacene.id' => $id_a)));
    }
    if ($this->RequestHandler->responseType() == 'json') {
      $add = '<button class="button green-gradient compact icon-plus" type="button" onclick="add(' . "',Producto.id,'" . ')">Add</button>';
      $acciones = "$add";
      $sql = "SELECT v.total FROM ventascelulares v WHERE v.producto_id = Producto.id $cond_sql ORDER BY v.id DESC LIMIT 1";
      $this->Producto->virtualFields = array(
        'imagen' => "CONCAT(IF(ISNULL(Producto.url_imagen),'',CONCAT('" . '<img src="../../../' . "',Producto.url_imagen,'" . '" height="51" width="51">' . "')))",
        'cantidad' => "$sql",
        'acciones' => "CONCAT('$acciones')"
      );
      /*debug($id_a);
      exit;*/
      $this->paginate = array(
        'fields' => array('Producto.imagen', 'Producto.nombre', 'Marca.nombre', 'Producto.cantidad', 'Producto.acciones'),
        'recursive' => 0,
        'order' => 'Producto.nombre DESC',
        'conditions' => array('Tiposproducto.nombre' => 'CELULARES')
      );
      $this->set('productos', $this->DataTable->getResponse('Almacenes', 'Producto'));
      $this->set('_serialize', 'productos');
    }
    $this->set(compact('almacen', 'id_a', 'es_almacen'));
  }

  public function ajax_entrega_cel($id_a = null, $es_alamacen = null, $idProducto = null) {
    $this->layout = 'ajax';
    $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.id' => $id_a)));
    $movimientos = $this->Ventascelulare->find('all', array('order' => 'Ventascelulare.id DESC', 'limit' => 10,
      'conditions' => array('Ventascelulare.producto_id' => $idProducto, 'Ventascelulare.almacene_id' => $id_a)
    ));
    $producto = $this->Producto->find('first', array(
      'fields' => array('Producto.nombre'),
      'conditions' => array('Producto.id' => $idProducto)
    ));
    if ($almacen['Almacene']['central'] != 1) {
      $Almacen_central = $this->Almacene->find('first', array('recursive' => -1, 'ALmacene.central' => 1));
      $ultimo = $this->Ventascelulare->find('first', array(
        'order' => 'Ventascelulare.id DESC', 'recursive' => -1,
        'conditions' => array('Ventascelulare.producto_id' => $idProducto, 'Ventascelulare.almacene_id' => $Almacen_central['Almacene']['id'])
      ));
    }
    $this->set(compact('movimientos', 'producto', 'idProducto', 'almacen', 'ultimo'));
  }

  public function registra_entrega() {
    $idProducto = $this->request->data['Ventascelulare']['producto_id'];
    $idAlmacen = $this->request->data['Ventascelulare']['almacene_id'];
    $almacen = $this->Almacene->findByid($idAlmacen, null, null, -1);
    $ultimo = $this->Ventascelulare->find('first', array(
      'order' => 'Ventascelulare.id DESC',
      'conditions' => array('Ventascelulare.producto_id' => $idProducto, 'Ventascelulare.almacene_id' => $idAlmacen)
    ));
    if (!empty($ultimo)) {
      $total = $ultimo['Ventascelulare']['total'] + $this->request->data['Ventascelulare']['entrada'];
    } else {
      $total = $this->request->data['Ventascelulare']['entrada'];
    }
    if ($almacen['Almacene']['central'] == 1) {
      $this->request->data['Ventascelulare']['total'] = $total;
      $this->Ventascelulare->create();
      $this->Ventascelulare->save($this->request->data['Ventascelulare']);
      $this->Session->setFlash('Se registro correctamente!!!' . 'msgbueno');
    } else {
      $Almacen_central = $this->Almacene->find('first', array('recursive' => -1, 'ALmacene.central' => 1));
      $ultimo_central = $this->Ventascelulare->find('first', array(
        'order' => 'Ventascelulare.id DESC',
        'recursive' => -1, 'conditions' => array('Ventascelulare.almacene_id' => $Almacen_central['Almacene']['id'], 'Ventascelulare.producto_id' => $idProducto
      )));
      if (!empty($ultimo_central)) {
        if ($ultimo_central['Ventascelulare']['total'] >= $this->request->data['Ventascelulare']['entrega']) {
          $this->request->data['Ventascelulare']['total'] = $total;
          $this->Ventascelulare->create();
          $this->Ventascelulare->save($this->request->data['Ventascelulare']);
          $this->request->data['Ventascelulare']['salida'] = $this->request->data['Ventascelulare']['entrada'];
          $this->request->data['Ventascelulare']['total'] = $ultimo_central['Ventascelulare']['total'] - $this->request->data['Ventascelulare']['salida'];
          $this->request->data['Ventascelulare']['almacene_id'] = $ultimo_central['Ventascelulare']['almacene_id'];
          $this->request->data['Ventascelulare']['sucursal_id'] = $ultimo_central['Ventascelulare']['sucursal_id'];
          $this->Ventascelulare->create();
          $this->Ventascelulare->save($this->request->data['Ventascelulare']);
          $this->Session->setFlash('Se registro correctamente!!!' . 'msgbueno');
        } else {
          $this->Session->setFlash('No hay sudiciente en almacen central!!', 'msgerror');
        }
      } else {
        $this->Session->setFlash('No hay sudiciente en almacen central!!', 'msgerror');
      }
    }
    $this->redirect(array('action' => 'entrega_celulares', $idAlmacen, 1));
  }

}
