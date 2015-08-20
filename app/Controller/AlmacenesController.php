
<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));
App::uses('AppController', 'Controller');

/**
 * Almacenes Controller
 *
 * @property Almacene $Almacene
 */
class AlmacenesController extends AppController {

  public $uses = array(
    'Almacene',
    'Tiposproducto',
    'Persona',
    'Producto', 'Movimiento',
    'Detalle', 'User', 'Deposito', 'Movimientosrecarga', 'Sucursal',
    'Banco', 'Ventascelulare', 'Pedido', 'Productosprecio',
    'Devuelto', 'Recargado',
    'Totale', 'Excel', 'Distribucione'
  );
  public $components = array('Session', 'Fechasconvert', 'RequestHandler', 'DataTable');
  public $layout = 'viva';

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
    $pedidos = array();

    $condiciones = array();
    if ($almacen == 1) {
      $condiciones['Totale.almacene_id'] = $idPersona;
    } else {
      $condiciones['Totale.persona_id'] = $idPersona;
    }
    $entregas = $this->Totale->find('all', array(
      'recursive' => 0,
      'conditions' => $condiciones,
      'fields' => array('Producto.nombre', 'Producto.proveedor', 'Totale.total', 'Totale.producto_id')
    ));
    $idDistribuidor = $this->User->find('first', array('fields' => array('User.id'), 'conditions' => array('User.persona_id' => $idPersona)));
    $ultima = $this->Pedido->find('first', array(
      'fields' => array('Pedido.numero'),
      'conditions' => array('Pedido.distribuidor_id' => $idDistribuidor['User']['id']),
      'order' => 'Pedido.id DESC'
    ));
    if (!empty($ultima)) {
      $pedidos = $this->Pedido->find('all', array(
        'conditions' => array('Pedido.distribuidor_id' => $idDistribuidor['User']['id'], 'Pedido.numero' => $ultima['Pedido']['numero'])
      ));
    }
    $this->set(compact('entregas', 'idPersona', 'nombre', 'almacen', 'pedidos'));
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

      $totalProducto = $this->get_total($idProducto, 1, $idAlmacenCentral);
      $num_transaccion = $this->get_num_trans();
      if ($almacen == 1) {
        if ($idAlmacenCentral == $idPersona) {
          $datos = array();
          $datos['producto_id'] = $idProducto;
          $datos['user_id'] = $this->Session->read('Auth.User.id');
          $datos['almacene_id'] = $idPersona;
          $datos['ingreso'] = $cantidad;
          $datos['salida'] = 0;
          $datos['transaccion'] = $num_transaccion;
          $this->Movimiento->create();
          $this->Movimiento->save($datos);
          $this->set_total($idProducto, 1, $idPersona, ($totalProducto + $cantidad));
          $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
        } else {
          if ($totalProducto >= $cantidad) {
            $datos = array();
            $datos['producto_id'] = $idProducto;
            $datos['user_id'] = $this->Session->read('Auth.User.id');
            $datos['almacene_id'] = $idPersona;
            $datos['ingreso'] = $cantidad;
            $datos['salida'] = 0;
            $datos['transaccion'] = $num_transaccion;
            $this->Movimiento->create();
            $this->Movimiento->save($datos);
            $this->set_total($idProducto, 1, $idPersona, ($this->get_total($idProducto, 1, $idPersona) + $cantidad));

            $datos = array();
            $datos['producto_id'] = $idProducto;
            $datos['user_id'] = $this->Session->read('Auth.User.id');
            $datos['almacene_id'] = $idAlmacenCentral;
            $datos['ingreso'] = 0;
            $datos['salida'] = $cantidad;
            $datos['transaccion'] = $num_transaccion;
            $this->Movimiento->create();
            $this->Movimiento->save($datos);
            $this->set_total($idProducto, 1, $idAlmacenCentral, ($totalProducto - $cantidad));
            $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
          } else {
            $this->Session->setFlash("No se pudo registrar en almacen hay " . $totalProducto, 'msgerror');
          }
        }
      } else {
        if ($totalProducto >= $cantidad) {
          $datos = array();
          $datos['producto_id'] = $idProducto;
          $datos['user_id'] = $this->Session->read('Auth.User.id');
          $datos['persona_id'] = $idPersona;
          $datos['ingreso'] = $cantidad;
          $datos['salida'] = 0;
          $datos['transaccion'] = $num_transaccion;
          $this->Movimiento->create();
          $this->Movimiento->save($datos);
          $this->set_total($idProducto, 0, $idPersona, ($this->get_total($idProducto, 0, $idPersona) + $cantidad));

          $datos = array();
          $datos['producto_id'] = $idProducto;
          $datos['user_id'] = $this->Session->read('Auth.User.id');
          $datos['almacene_id'] = $idAlmacenCentral;
          $datos['ingreso'] = 0;
          $datos['salida'] = $cantidad;
          $datos['transaccion'] = $num_transaccion;
          $this->Movimiento->create();
          $this->Movimiento->save($datos);
          $this->set_total($idProducto, 1, $idAlmacenCentral, ($totalProducto - $cantidad));
          $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
        } else {
          $this->Session->setFlash("No se pudo registrar en almacen hay " . $totalProducto, 'msgerror');
        }
      }
      $this->redirect(array('action' => 'listaentregas', $idPersona, $almacen));
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

  public function ajaxproductos2($idCategoria = null, $almacen = null) {
    $this->layout = 'ajax';
    $productos = $this->Producto->find('all', array(
      'conditions' => array('Producto.tiposproducto_id' => $idCategoria),
      'recursive' => 0));
    //debug($productos);exit;
    $this->set(compact('productos', 'almacen'));
  }

  public function ajaxcantidad($idProducto = null, $almacen = null) {

    $cantidad = $this->get_total($idProducto, 1, 1);
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
      $cond_sql = "AND t.almacene_id = $id_a";
      $almacen = $this->Almacene->find('first', array('fields' => array('Sucursal.nombre'), 'conditions' => array('Almacene.id' => $id_a)));
    }
    if ($this->RequestHandler->responseType() == 'json') {
      $add = '<button class="button green-gradient compact icon-plus" type="button" onclick="add(' . "',Producto.id,'" . ')">Add</button>';
      //$detalle = '<button class="button blue-gradient compact" type="button" onclick="detalle(' . "',Producto.id,'" . ')">Detalle</button>';
      $acciones = "$add";
      $sql = "SELECT t.total FROM totales t WHERE t.producto_id = Producto.id $cond_sql LIMIT 1";
      $this->Producto->virtualFields = array(
        'imagen' => "CONCAT(IF(ISNULL(Producto.url_imagen),'',CONCAT('" . '<img src="../../../' . "',Producto.url_imagen,'" . '" height="51" width="51">' . "')))",
        'cantidad' => "($sql)",
        'acciones' => "CONCAT('$acciones')"
      );
      /* debug($id_a);
        exit; */
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
      $ultimo_total = $this->get_total($idProducto, 1, $Almacen_central['Almacene']['id']);
    }
    $this->set(compact('movimientos', 'producto', 'idProducto', 'almacen', 'ultimo_total'));
  }

  public function ajax_detalle_cel($id_a = null, $es_alamacen = null, $idProducto = null) {
    $this->layout = 'ajax';

    $condiciones = array();
    $condiciones['Ventascelulare.producto_id'] = $idProducto;
    $condiciones['Ventascelulare.almacene_id'] = $id_a;

    $movimientos = $this->Ventascelulare->find('all', array(
      'conditions' => $condiciones,
      'order' => array('Ventascelulare.id DESC'),
      'limit' => 10,
      'recursive' => -1
    ));
    $ultimo = $this->Ventascelulare->find('first', array(
      'order' => 'Ventascelulare.id DESC',
      'conditions' => array('Ventascelulare.producto_id' => $idProducto),
      'fields' => array('Ventascelulare.transaccion')
    ));
    $this->set(compact('movimientos', 'ultimo'));
  }

  public function registra_entrega() {
    $idProducto = $this->request->data['Ventascelulare']['producto_id'];
    $idAlmacen = $this->request->data['Ventascelulare']['almacene_id'];
    $almacen = $this->Almacene->findByid($idAlmacen, null, null, -1);

    $total = $this->get_total($idProducto, 1, $idAlmacen) + $this->request->data['Ventascelulare']['entrada'];
    $num_transaccion = $this->get_num_trans_cel();
    if ($almacen['Almacene']['central'] == 1) {
      //$this->request->data['Ventascelulare']['total'] = $total;
      $this->request->data['Ventascelulare']['transaccion'] = $num_transaccion;
      $this->Ventascelulare->create();
      $this->Ventascelulare->save($this->request->data['Ventascelulare']);
      $this->set_total($idProducto, 1, $idAlmacen, $total);
      $this->Session->setFlash('Se registro correctamente!!!' . 'msgbueno');
    } else {
      $Almacen_central = $this->Almacene->find('first', array('recursive' => -1, 'ALmacene.central' => 1));
      $ultimo_central = $this->Ventascelulare->find('first', array(
        'order' => 'Ventascelulare.id DESC',
        'recursive' => -1, 'conditions' => array('Ventascelulare.almacene_id' => $Almacen_central['Almacene']['id'], 'Ventascelulare.producto_id' => $idProducto
      )));
      $total_ultimo_c = $this->get_total($idProducto, 1, $Almacen_central['Almacene']['id']);
      if ($total_ultimo_c >= $this->request->data['Ventascelulare']['entrega']) {
        //$this->request->data['Ventascelulare']['total'] = $total;
        $this->request->data['Ventascelulare']['transaccion'] = $num_transaccion;
        $this->Ventascelulare->create();
        $this->Ventascelulare->save($this->request->data['Ventascelulare']);
        $this->set_total($idProducto, 1, $idAlmacen, $total);
        $this->request->data['Ventascelulare']['salida'] = $this->request->data['Ventascelulare']['entrada'];
        //$this->request->data['Ventascelulare']['total'] = $total_ultimo_c - $this->request->data['Ventascelulare']['salida'];
        $this->request->data['Ventascelulare']['almacene_id'] = $Almacen_central['Almacene']['id'];
        $this->request->data['Ventascelulare']['sucursal_id'] = $Almacen_central['Almacene']['sucursal_id'];
        $this->request->data['Ventascelulare']['transaccion'] = $num_transaccion;
        $this->request->data['Ventascelulare']['entrada'] = 0;
        $this->Ventascelulare->create();
        $this->Ventascelulare->save($this->request->data['Ventascelulare']);
        $this->set_total($idProducto, 1, $Almacen_central['Almacene']['id'], ($total_ultimo_c - $this->request->data['Ventascelulare']['salida']));
        $this->Session->setFlash('Se registro correctamente!!!' . 'msgbueno');
      } else {
        $this->Session->setFlash('No hay sudiciente en almacen central!!', 'msgerror');
      }
    }
    $this->redirect(array('action' => 'entrega_celulares', $idAlmacen, 1));
  }

  public function devuelto($idPersona = null) {
    $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.persona_id = $idPersona AND Producto.id = mo.producto_id LIMIT 1)";
    $this->Movimiento->virtualFields = array(
      'total_s' => "CONCAT($sql1)"
    );
    $distribuidor = $this->Persona->findByid($idPersona, null, null, -1);
    $ult_movimientos = $this->Movimiento->find('all', array(
      'conditions' => array('Movimiento.devuelto_id' => NULL, 'Movimiento.persona_id' => $idPersona, 'Movimiento.salida !=' => NULL),
      'group' => array('Movimiento.producto_id'),
      'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.total_s', 'Movimiento.created'),
      'order' => array('Movimiento.created', 'Producto.nombre')
    ));
    $devueltos = $this->Devuelto->find('all', array(
      'group' => array('created'),
      'order' => array('created DESC'),
      'fields' => array('created')
    ));

    $datos = $this->Movimiento->find('all', array(
      'recursive' => 0, 'order' => 'Movimiento.producto_id',
      'conditions' => array('Movimiento.persona_id' => $idPersona, 'Movimiento.created' => date('Y-m-d'), 'Movimiento.salida !=' => NULL),
      'group' => array('Movimiento.producto_id'),
      'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.total_s')
    ));
    foreach ($datos as $key => $da) {
      $datos_aux = $this->Movimiento->find('all', array(
        'recursive' => -1, 'order' => 'Movimiento.producto_id',
        'conditions' => array('Movimiento.persona_id' => $idPersona, 'Movimiento.created' => date('Y-m-d'), 'Movimiento.precio_uni !=' => NULL, 'Movimiento.producto_id' => $da['Producto']['id'], 'Movimiento.salida !=' => NULL),
        'group' => array('Movimiento.precio_uni'),
        'fields' => array('SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total', 'Movimiento.producto_id')
      ));
      $datos[$key]['precios'] = $datos_aux;
      //debug($datos);exit;
    }
    $recargas = $this->Recargado->find('all', array(
      'conditions' => array('Recargado.persona_id' => $idPersona, 'DATE(Recargado.created)' => date('Y-m-d'))
    ));
    $this->set(compact('ult_movimientos', 'distribuidor', 'devueltos', 'datos', 'recargas', 'recargas'));
    //debug($ult_movimientos);exit;
  }

  public function registra_devuelto($idPersona = null) {
    /* debug($this->request->data);
      exit; */
    if (!empty($this->request->data['Devuelto'])) {
      $almac_cent = $this->Almacene->find('first', array('conditions' => array('central' => 1), 'fields' => array('Almacene.id')));
      $usuario = $this->User->findBypersona_id($idPersona, null, null, -1);
      $num_trans = $this->get_num_trans();
      foreach ($this->request->data['Devuelto'] as $dev) {
        $dmov['devuelto_id'] = NULL;
        $this->Devuelto->create();
        $this->Devuelto->save($dev);
        $idDevuelto = $this->Devuelto->getLastInsertID();
        $ult_movimientos = $this->Movimiento->find('all', array(
          'conditions' => array('Movimiento.devuelto_id' => null, 'Movimiento.persona_id' => $idPersona, 'Movimiento.salida !=' => NULL, 'Movimiento.producto_id' => $dev['producto_id']),
          'fields' => array('Movimiento.id')
        ));
        $dmov['devuelto_id'] = $idDevuelto;
        foreach ($ult_movimientos as $ul) {
          $this->Movimiento->id = $ul['Movimiento']['id'];
          $this->Movimiento->save($dmov);
        }
        $nue_mov['producto_id'] = $dev['producto_id'];
        $nue_mov['user_id'] = $usuario['User']['id'];
        $nue_mov['persona_id'] = $idPersona;
        $nue_mov['salida'] = $dev['cantidad'];
        //$nue_mov['total'] = $dev['total'] - $dev['cantidad'];
        $nue_mov['devuelto_id'] = $idDevuelto;
        $nue_mov['transaccion'] = $num_trans;
        $this->Movimiento->create();
        $this->Movimiento->save($nue_mov);
        $this->set_total($dev['producto_id'], 0, $idPersona, ($dev['total'] - $dev['cantidad']));

        $nue_mov = null;
        $total_central = $this->get_total($dev['producto_id'], 1, $almac_cent['Almacene']['id']);
        $nue_mov['producto_id'] = $dev['producto_id'];
        $nue_mov['user_id'] = $this->Session->read('Auth.User.id');
        $nue_mov['almacene_id'] = $almac_cent['Almacene']['id'];
        $nue_mov['ingreso'] = $dev['cantidad'];
        //$nue_mov['total'] = $ult_almac['Movimiento']['total'] + $dev['cantidad'];
        $nue_mov['devuelto_id'] = $idDevuelto;
        $nue_mov['transaccion'] = $num_trans;
        $this->Movimiento->create();
        $this->Movimiento->save($nue_mov);
        $this->set_total($dev['producto_id'], 1, $almac_cent['Almacene']['id'], ($total_central + $dev['cantidad']));
        $nue_mov = null;
      }
      $this->Session->setFlash('Se registro correctamente!!', 'msgbueno');
    } else {
      $this->Session->setFlash("No se pudo registrar!!", 'msgerror');
    }
    $this->redirect(array('action' => 'devuelto', $idPersona));
  }

  public function registra_regularizacion() {
    /* debug($this->request->data);
      exit; */
    $dmov = $this->request->data['Movimiento'];
    $total_d = 0;
    if (!empty($dmov['persona_id'])) {
      $d_distrib = $this->Movimiento->find('first', array(
        'conditions' => array('Movimiento.persona_id' => $dmov['persona_id'], 'Movimiento.producto_id' => $dmov['producto_id']),
        'order' => array('Movimiento.id DESC'),
        'fields' => array('Movimiento.total')
      ));
      if (!empty($d_distrib)) {
        $total_d = $d_distrib['Movimiento']['total'];
      }
    } else {
      $d_alma = $this->Movimiento->find('first', array(
        'conditions' => array('Movimiento.almacene_id' => $dmov['almacene_id'], 'Movimiento.producto_id' => $dmov['producto_id']),
        'order' => array('Movimiento.id DESC'),
        'fields' => array('Movimiento.total')
      ));
      if (!empty($d_alma)) {
        $total_d = $d_alma['Movimiento']['total'];
      }
    }
    $idProducto = $dmov['producto_id'];
    $total_cent = $this->get_tot_cent($idProducto);
    if ($dmov['tipo'] == 'Entrega') {
      if ($total_cent >= $dmov['cantidad']) {
        $dmov['ingreso'] = $dmov['cantidad'];
        $dmov['total'] = $total_d + $dmov['ingreso'];
        $dmov['user_id'] = $this->Session->read('Auth.User.id');
        $this->Movimiento->create();
        $this->Movimiento->save($dmov);

        $dmov['almacene_id'] = $this->get_id_alm_cent();
        $dmov['total'] = $total_cent - $dmov['cantidad'];
        $dmov['salida'] = $dmov['cantidad'];
        $dmov['ingreso'] = NULL;
        $dmov['persona_id'] = NULL;
        $this->Movimiento->create();
        $this->Movimiento->save($dmov);
        $this->Session->setFlash("Se regularizo correctamente!!", 'msgbueno');
      } else {
        $this->Session->setFlash("La cantidad en almacen central es de " . $total_cent, 'msgerror');
      }
    } else {
      if ($total_d >= $dmov['cantidad']) {
        $dmov['salida'] = $dmov['cantidad'];
        $dmov['total'] = $total_d - $dmov['salida'];
        $dmov['user_id'] = $this->Session->read('Auth.User.id');
        $this->Movimiento->create();
        $this->Movimiento->save($dmov);

        $dmov['almacene_id'] = $this->get_id_alm_cent();
        $dmov['total'] = $total_cent + $dmov['cantidad'];
        $dmov['ingreso'] = $dmov['cantidad'];
        $dmov['salida'] = NULL;
        $dmov['persona_id'] = NULL;
        $this->Movimiento->create();
        $this->Movimiento->save($dmov);
        $this->Session->setFlash("Se regularizo correctamente!!", 'msgbueno');
      } else {
        $this->Session->setFlash("La cantidad del distribuidor es de " . $total_d, 'msgerror');
      }
    }
    $this->redirect($this->referer());
  }

  //devuelve el id del almacen central
  public function get_id_alm_cent() {
    $almacen = $this->Almacene->find('first', array('recursive' => -1, 'conditions' => array('Almacene.central' => 1), 'fields' => array('Almacene.id')));
    if (!empty($almacen)) {
      return $almacen['Almacene']['id'];
    } else {
      return 0;
    }
  }

  //devuelve total enalmacen central 
  public function get_tot_cent($idProducto = null) {
    $almacen = $this->Movimiento->find('first', array(
      'order' => array('Movimiento.id DESC'),
      'conditions' => array('Movimiento.almacene_id' => $this->get_id_alm_cent(), 'Movimiento.producto_id' => $idProducto),
      'fields' => array('Movimiento.total')
    ));
    if (!empty($almacen)) {
      return $almacen['Movimiento']['total'];
    } else {
      return 0;
    }
  }

  public function detalle_mov($idProducto = null, $id = null, $almacen = null) {
    $this->layout = 'ajax';
    $condiciones = array();
    $condiciones['Movimiento.producto_id'] = $idProducto;
    $condiciones['Movimiento.salida'] = 0;
    if ($almacen == 1) {
      $condiciones['Movimiento.almacene_id'] = $id;
    } else {
      $condiciones['Movimiento.persona_id'] = $id;
    }
    $movimientos = $this->Movimiento->find('all', array(
      'conditions' => $condiciones,
      'order' => array('Movimiento.id DESC'),
      'limit' => 10,
      'recursive' => -1
    ));
    $this->set(compact('movimientos', 'almacen'));
  }

  public function principal() {
    $idCentral = $this->get_id_alm_cent();
    $sql = "SELECT t.total FROM totales t WHERE t.almacene_id = $idCentral AND t.producto_id = Producto.id LIMIT 1";
    $this->Producto->virtualFields = array(
      'total_central' => "CONCAT(($sql))"
    );
    $productos = $this->Producto->find('all', array(
      'recursive' => -1,
      //'conditions' => array('Producto.total_central' => 0),
      'order' => array('Producto.total_central ASC'),
      'limit' => 4,
      'fields' => array('Producto.id', 'Producto.nombre', 'Producto.total_central')
    ));
    $meses = $this->get_meses();
    $this->set(compact('productos', 'meses'));
  }

  public function get_vent_mes($idProducto = null, $mes = null) {
    $movimiento = $this->Movimiento->find('all', array(
      'recursive' => -1,
      'conditions' => array('Movimiento.producto_id' => $idProducto, 'MONTH(Movimiento.created)' => $mes, 'YEAR(Movimiento.created)' => date('Y'), 'Movimiento.cliente_id !=' => NULL),
      'group' => array('Movimiento.producto_id'),
      'fields' => array('SUM(Movimiento.salida) as s_total')
    ));
    return $movimiento[0][0]['s_total'];
  }

  public function get_meses() {
    $meses = $this->Movimiento->find('all', array(
      'conditions' => array('YEAR(Movimiento.created)' => date("Y")),
      'group' => array('MONTH(Movimiento.created)'),
      'recursive' => -1,
      'fields' => array('MONTH(Movimiento.created) as mes')
    ));
    foreach ($meses as $key => $me) {
      switch ($me[0]['mes']) {
        case 1:
          $meses[$key][0]['nombre'] = "ENERO";
          break;
        case 2:
          $meses[$key][0]['nombre'] = "FEBRERO";
          break;
        case 3:
          $meses[$key][0]['nombre'] = "MARZO";
          break;
        case 4:
          $meses[$key][0]['nombre'] = "ABRIL";
          break;
        case 5:
          $meses[$key][0]['nombre'] = "MAYO";
          break;
        case 6:
          $meses[$key][0]['nombre'] = "JUNIO";
          break;
        case 7:
          $meses[$key][0]['nombre'] = "JULIO";
          break;
        case 8:
          $meses[$key][0]['nombre'] = "AGOSTO";
          break;
        case 9:
          $meses[$key][0]['nombre'] = "SEPTIEMBRE";
          break;
        case 10:
          $meses[$key][0]['nombre'] = "OCTUBRE";
          break;
        case 11:
          $meses[$key][0]['nombre'] = "NOVIEMBRE";
          break;
        case 12:
          $meses[$key][0]['nombre'] = "DICIEMBRE";
          break;
      }
    }
    return $meses;
  }

  public function get_num_trans() {
    $ultimo = $this->Movimiento->find('first', array(
      'order' => 'Movimiento.id DESC',
      'recursive' => -1,
      'fields' => array('Movimiento.transaccion')
    ));
    if (!empty($ultimo)) {
      return $ultimo['Movimiento']['transaccion'] + 1;
    } else {
      return 1;
    }
  }

  public function get_num_trans_cel() {
    $ultimo = $this->Ventascelulare->find('first', array(
      'order' => 'Ventascelulare.id DESC',
      'recursive' => -1,
      'fields' => array('Ventascelulare.transaccion')
    ));
    if (!empty($ultimo)) {
      return $ultimo['Ventascelulare']['transaccion'] + 1;
    } else {
      return 1;
    }
  }

  public function elimina_movimiento($numTransaccion = NULL, $almacen = null) {
    $movimiento = $this->Movimiento->find('first', array(
      'recursive' => 0,
      'conditions' => array('Movimiento.transaccion' => $numTransaccion, 'Movimiento.salida' => 0),
      'fields' => array('Movimiento.ingreso', 'Almacene.id', 'Almacene.central', 'Movimiento.producto_id', 'Movimiento.persona_id')
    ));
    if ($almacen == 1) {
      $total = $this->get_total($movimiento['Movimiento']['producto_id'], 1, $movimiento['Almacene']['id']);
      if ($movimiento['Almacene']['central'] != 1) {
        $total_c = $this->get_total($movimiento['Movimiento']['producto_id'], 1, 1);
        $this->set_total($movimiento['Movimiento']['producto_id'], 1, 1, ($total_c + $movimiento['Movimiento']['ingreso']));
      }
      $this->set_total($movimiento['Movimiento']['producto_id'], 1, $movimiento['Almacene']['id'], ($total - $movimiento['Movimiento']['ingreso']));
    } else {
      $total = $this->get_total($movimiento['Movimiento']['producto_id'], 0, $movimiento['Movimiento']['persona_id']);
      $total_c = $this->get_total($movimiento['Movimiento']['producto_id'], 1, 1);
      $this->set_total($movimiento['Movimiento']['producto_id'], 1, 1, ($total_c + $movimiento['Movimiento']['ingreso']));
      $this->set_total($movimiento['Movimiento']['producto_id'], 0, $movimiento['Movimiento']['persona_id'], ($total - $movimiento['Movimiento']['ingreso']));
    }
    $this->Movimiento->deleteAll(array('Movimiento.transaccion' => $numTransaccion));
    $this->Session->setFlash("Se elimino correctamente el movimiento!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function quita_ent_cel($numTransaccion = NULL) {
    $movimiento = $this->Ventascelulare->find('first', array(
      'recursive' => 0,
      'conditions' => array('Ventascelulare.transaccion' => $numTransaccion, 'Ventascelulare.salida' => 0),
      'fields' => array('Ventascelulare.entrada', 'Almacene.id', 'Almacene.central', 'Ventascelulare.producto_id', 'Ventascelulare.persona_id')
    ));
    $total = $this->get_total($movimiento['Ventascelulare']['producto_id'], 1, $movimiento['Almacene']['id']);
    if ($movimiento['Almacene']['central'] != 1) {
      $total_c = $this->get_total($movimiento['Ventascelulare']['producto_id'], 1, 1);
      $this->set_total($movimiento['Ventascelulare']['producto_id'], 1, 1, ($total_c + $movimiento['Ventascelulare']['entrada']));
    }
    $this->set_total($movimiento['Ventascelulare']['producto_id'], 1, $movimiento['Almacene']['id'], ($total - $movimiento['Ventascelulare']['entrada']));
    $this->Ventascelulare->deleteAll(array('Ventascelulare.transaccion' => $numTransaccion));
    $this->Session->setFlash("Se elimino correctamente el registro!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function set_total($idProducto = null, $es_almacen = null, $id = null, $total = null) {
    $condiciones = array();
    $condiciones['Totale.producto_id'] = $idProducto;
    if ($es_almacen == 1) {
      $condiciones['Totale.almacene_id'] = $id;
      $datos_t['almacene_id'] = $id;
    } else {
      $condiciones['Totale.persona_id'] = $id;
      $datos_t['persona_id'] = $id;
    }
    $dato_total = $this->Totale->find('first', array(
      'recursive' => -1,
      'conditions' => $condiciones,
      'fields' => array('Totale.id')
    ));
    if (!empty($dato_total)) {
      $this->Totale->id = $dato_total['Totale']['id'];
    } else {
      $this->Totale->create();
    }
    $datos_t['producto_id'] = $idProducto;
    $datos_t['total'] = $total;
    $this->Totale->save($datos_t);
  }

  public function get_total($idProducto = null, $es_almacen = null, $id = null) {
    $condiciones = array();
    $condiciones['Totale.producto_id'] = $idProducto;
    if ($es_almacen == 1) {
      $condiciones['Totale.almacene_id'] = $id;
    } else {
      $condiciones['Totale.persona_id'] = $id;
    }
    $dato_total = $this->Totale->find('first', array(
      'recursive' => -1,
      'conditions' => $condiciones,
      'fields' => array('Totale.total')
    ));
    if (!empty($dato_total)) {
      return $dato_total['Totale']['total'];
    } else {
      return 0;
    }
  }

  public function excel() {
    $excels = $this->Excel->find('all', array(
      'order' => array('Excel.id DESC'),
      'conditions' => array('tipo' => array('distribucion', 'distribucion completa')),
      'limit' => 30));
    $this->set(compact('excels'));
  }

  public function guardaexcel() {
    //debug($this->request->data);die;
    $archivoExcel = $this->request->data['Excel']['excel'];
    $nombreOriginal = $this->request->data['Excel']['excel']['name'];
    //App::uses('String', 'Utility');
    if ($archivoExcel['error'] === UPLOAD_ERR_OK) {
      $nombre = String::uuid();
      if (move_uploaded_file($archivoExcel['tmp_name'], WWW_ROOT . 'files' . DS . $nombre . '.xlsx')) {
        $nombreExcel = $nombre . '.xlsx';
        $direccionExcel = WWW_ROOT . 'files';
        $this->request->data['Excelg']['nombre'] = $nombreExcel;
        $this->request->data['Excelg']['nombre_original'] = $nombreOriginal;
        $this->request->data['Excelg']['direccion'] = "";
        $this->request->data['Excelg']['tipo'] = "distribucion";
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
            'C' => '');
          foreach ($cellIterator as $cell) {
            if ('A' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('B' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('C' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            }
          }
        }
      }
      $idCentral = $this->get_id_alm_cent();
      $idUser = $this->Session->read('Auth.User.id');
      foreach ($array_data as $da) {
        $d_dis = array();
        $producto = $this->Producto->find('first', array(
          'recursive' => -1,
          'conditions' => array('nombre' => $da['A']),
          'fields' => array('Producto.id')
        ));
        $tienda = $this->Almacene->find('first', array(
          'recursive' => 0,
          'conditions' => array('Sucursal.nombre' => $da['B']),
          'fields' => array('Almacene.id', 'Sucursal.id', 'Almacene.central')
        ));
        $d_dis['nombre_producto'] = $da['A'];
        $d_dis['nombre_tienda'] = $da['B'];
        $d_dis['cantidad'] = $da['C'];
        $d_dis['excel_id'] = $ultimoExcel;
        if (!empty($producto) && !empty($tienda) && !empty($da['C'])) {
          $d_dis['almacene_id'] = $tienda['Almacene']['id'];
          $d_dis['sucursal_id'] = $tienda['Sucursal']['id'];
          $d_dis['producto_id'] = $producto['Producto']['id'];
          if ($tienda['Almacene']['central'] == 1) {
            $total_c = $this->get_total($d_dis['producto_id'], 1, $idCentral);
            $d_dis['estado'] = 'Correcto';
            $d_mov = array();
            $d_mov['producto_id'] = $d_dis['producto_id'];
            $d_mov['user_id'] = $idUser;
            $d_mov['almacene_id'] = $d_dis['almacene_id'];
            $d_mov['ingreso'] = $da['C'];
            $this->Movimiento->create();
            $this->Movimiento->save($d_mov);
            $this->set_total($d_dis['producto_id'], 1, $d_dis['almacene_id'], ($total_c + $da['C']));
          } else {
            $total_c = $this->get_total($d_dis['producto_id'], 1, $idCentral);
            if ($total_c >= $da['C']) {
              $d_dis['estado'] = 'Correcto';
              $d_mov = array();
              $d_mov['producto_id'] = $d_dis['producto_id'];
              $d_mov['user_id'] = $idUser;
              $d_mov['almacene_id'] = $idCentral;
              $d_mov['salida'] = $da['C'];
              $this->Movimiento->create();
              $this->Movimiento->save($d_mov);
              $this->set_total($d_dis['producto_id'], 1, $idCentral, ($total_c - $da['C']));
              $d_mov = array();
              $d_mov['producto_id'] = $d_dis['producto_id'];
              $d_mov['user_id'] = $idUser;
              $d_mov['almacene_id'] = $d_dis['almacene_id'];
              $d_mov['ingreso'] = $da['C'];
              $this->Movimiento->create();
              $this->Movimiento->save($d_mov);
              $total_p = $this->get_total($d_dis['producto_id'], 1, $d_dis['almacene_id']);
              $this->set_total($d_dis['producto_id'], 1, $d_dis['almacene_id'], ($total_p + $da['C']));
            } else {
              $d_dis['estado'] = 'No Correcto';
            }
          }
        } else {
          $d_dis['estado'] = 'No Correcto';
        }
        $this->Distribucione->create();
        $this->Distribucione->save($d_dis);
      }

      $this->Session->setFlash("Se registro correctamente el excel!!", 'msgbueno');
      $this->redirect($this->referer());
      //fin funciones del excel
    } else {
      $this->Session->setFlash("No se pudo registrar el excel intente nuevamente!!!", 'msgerror');
      $this->redirect($this->referer());
      //echo 'no';
    }
  }

  public function guardaexcelcomp() {
    //debug($this->request->data);die;
    $archivoExcel = $this->request->data['Excel']['excel'];
    $nombreOriginal = $this->request->data['Excel']['excel']['name'];
    //App::uses('String', 'Utility');
    if ($archivoExcel['error'] === UPLOAD_ERR_OK) {
      $nombre = String::uuid();
      if (move_uploaded_file($archivoExcel['tmp_name'], WWW_ROOT . 'files' . DS . $nombre . '.xlsx')) {
        $nombreExcel = $nombre . '.xlsx';
        $direccionExcel = WWW_ROOT . 'files';
        $this->request->data['Excelg']['nombre'] = $nombreExcel;
        $this->request->data['Excelg']['nombre_original'] = $nombreOriginal;
        $this->request->data['Excelg']['direccion'] = "";
        $this->request->data['Excelg']['tipo'] = "distribucion";
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
            'C' => '');
          foreach ($cellIterator as $cell) {
            if ('A' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('B' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('C' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            }
          }
        }
      }
      $idCentral = $this->get_id_alm_cent();
      $idUser = $this->Session->read('Auth.User.id');
      foreach ($array_data as $da) {
        $d_dis = array();
        $producto = $this->Producto->find('first', array(
          'recursive' => -1,
          'conditions' => array('nombre' => $da['A']),
          'fields' => array('Producto.id')
        ));
        $tienda = $this->Almacene->find('first', array(
          'recursive' => 0,
          'conditions' => array('Sucursal.nombre' => $da['B']),
          'fields' => array('Almacene.id', 'Sucursal.id', 'Almacene.central')
        ));
        $d_dis['nombre_producto'] = $da['A'];
        $d_dis['nombre_tienda'] = $da['B'];
        $d_dis['cantidad'] = $da['C'];
        $d_dis['excel_id'] = $ultimoExcel;
        if (!empty($producto) && !empty($tienda) && !empty($da['C'])) {
          $d_dis['almacene_id'] = $tienda['Almacene']['id'];
          $d_dis['sucursal_id'] = $tienda['Sucursal']['id'];
          $d_dis['producto_id'] = $producto['Producto']['id'];
          if ($tienda['Almacene']['central'] == 1) {
            $total_c = $this->get_total($d_dis['producto_id'], 1, $idCentral);
            $d_dis['estado'] = 'Correcto';
            $d_mov = array();
            $d_mov['producto_id'] = $d_dis['producto_id'];
            $d_mov['user_id'] = $idUser;
            $d_mov['almacene_id'] = $d_dis['almacene_id'];
            $d_mov['ingreso'] = $da['C'];
            $this->Movimiento->create();
            $this->Movimiento->save($d_mov);
            $this->set_total($d_dis['producto_id'], 1, $d_dis['almacene_id'], ($total_c + $da['C']));
          } else {
            $total_c = $this->get_total($d_dis['producto_id'], 1, $idCentral);
            $d_dis['estado'] = 'Correcto';
            $d_mov = array();
            $d_mov['producto_id'] = $d_dis['producto_id'];
            $d_mov['user_id'] = $idUser;
            $d_mov['almacene_id'] = $idCentral;
            $d_mov['ingreso'] = $da['C'];
            $this->Movimiento->create();
            $this->Movimiento->save($d_mov);
            $this->set_total($d_dis['producto_id'], 1, $idCentral, ($total_c + $da['C']));
            $total_c = $this->get_total($d_dis['producto_id'], 1, $idCentral);
            $d_mov = array();
            $d_mov['producto_id'] = $d_dis['producto_id'];
            $d_mov['user_id'] = $idUser;
            $d_mov['almacene_id'] = $idCentral;
            $d_mov['salida'] = $da['C'];
            $this->Movimiento->create();
            $this->Movimiento->save($d_mov);
            $this->set_total($d_dis['producto_id'], 1, $idCentral, ($total_c - $da['C']));
            $d_mov = array();
            $d_mov['producto_id'] = $d_dis['producto_id'];
            $d_mov['user_id'] = $idUser;
            $d_mov['almacene_id'] = $d_dis['almacene_id'];
            $d_mov['ingreso'] = $da['C'];
            $this->Movimiento->create();
            $this->Movimiento->save($d_mov);
            $total_p = $this->get_total($d_dis['producto_id'], 1, $d_dis['almacene_id']);
            $this->set_total($d_dis['producto_id'], 1, $d_dis['almacene_id'], ($total_p + $da['C']));
          }
        } else {
          $d_dis['estado'] = 'No Correcto';
        }
        $this->Distribucione->create();
        $this->Distribucione->save($d_dis);
      }

      $this->Session->setFlash("Se registro correctamente el excel!!", 'msgbueno');
      $this->redirect($this->referer());
      //fin funciones del excel
    } else {
      $this->Session->setFlash("No se pudo registrar el excel intente nuevamente!!!", 'msgerror');
      $this->redirect($this->referer());
      //echo 'no';
    }
  }

  public function verexcel($idExcel = null) {
    $excel = $this->Excel->findByid($idExcel, null, null, -1);
    $distribuciones = $this->Distribucione->find('all', array(
      'recursive' => -1,
      'conditions' => array('Distribucione.excel_id' => $idExcel)
    ));
    $this->set(compact('distribuciones', 'excel'));
  }

}
