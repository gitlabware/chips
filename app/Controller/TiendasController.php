<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class TiendasController extends AppController {

  public $name = 'Tiendas';
  public $layout = 'tienda';
  public $uses = array(
    'Productosprecio',
    'Sucursal',
    'User',
    'Movimiento',
    'Producto',
    'Ventastienda',
    'Cliente',
    'Tiposproducto',
    'Chip',
    'Almacene',
    'Recarga', 'Ventascelulare',
    'Deposito', 'Recargascabina', 'Cabina', 'Movimientoscabina', 'Pago', 'Rutasusuario', 'Totale'
  );
  public $components = array('RequestHandler', 'DataTable');

  public function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  public function ajaxpidetienda($id = null, $idProducto = null, $precio = null) {
    
  }

  public function get_id_almacen() {
    $almacen = $this->Almacene->find('first', array(
      'conditions' => array('Almacene.sucursal_id' => $this->Session->read('Auth.User.sucursal_id'))
    ));
    return $almacen['Almacene']['id'];
  }

  public function get_total_almacen($idProducto = null) {
    $movimiento = $this->Movimiento->find('first', array(
      'order' => 'Movimiento.id DESC',
      'conditions' => array('Movimiento.almacene_id' => $this->get_id_almacen(), 'Movimiento.producto_id' => $idProducto)
    ));
    /* debug($movimiento);
      exit; */
    if (!empty($movimiento)) {
      return $movimiento['Movimiento']['total'];
    } else {
      return 0;
    }
  }

  public function ajax_cantidad_prod($idProducto = null) {
    $this->layout = 'ajax';
    $producto = $this->Producto->findByid($idProducto, null, null, -1);
    $cantidad = $this->get_total_almacen($idProducto);
    //debug($cantidad);exit;
    $this->set(compact('producto', 'cantidad'));
  }

  public function registra_venta_t() {
    $idAlmacen = $this->get_id_almacen();
    foreach ($this->request->data['productos'] as $key => $ped) {
      $total = $this->get_total($key, 1, $idAlmacen);
      if ($ped['cantidad'] > $total) {
        $this->Session->setFlash('No se pudo registrar verifique las cantidades antes!!!', 'msgerror');
        $this->redirect(array('action' => 'index'));
      }
    }
    $numerot = $this->get_num_trans();
    foreach ($this->request->data['productos'] as $key => $ped) {
      $total = $this->get_total($key, 1, $idAlmacen);
      $this->Movimiento->create();
      $this->request->data['Movimiento']['producto_id'] = $key;
      $this->request->data['Movimiento']['user_id'] = $this->Session->read('Auth.User.id');
      $this->request->data['Movimiento']['sucursal_id'] = $this->Session->read('Auth.User.sucursal_id');
      $this->request->data['Movimiento']['almacene_id'] = $idAlmacen;
      $this->request->data['Movimiento']['escala'] = 'TIENDA';
      $this->request->data['Movimiento']['salida'] = $ped['cantidad'];
      $this->request->data['Movimiento']['precio_uni'] = $ped['precio'];
      $this->request->data['Movimiento']['ingreso'] = 0;
      $this->request->data['Movimiento']['transaccion'] = $numerot;
      $this->Movimiento->save($this->request->data['Movimiento']);
      $this->set_total($key, 1, $idAlmacen, ($total - $ped['cantidad']));
    }
    $this->Session->setFlash('Venta registrada', 'msgbueno');
    $this->redirect(array('action' => 'index'));
  }

  public function ajaxquita($id = null, $canti = null, $precio = null) {

    $this->layout = 'ajax';
    $cantidad = $canti - 1;
    $movimiento = $this->Movimiento->find('first', array('order' => 'Movimiento.id DESC', 'conditions' => array('ventastienda_id' => $id)));
    $idmovimiento = $movimiento['Movimiento']['id'];
    $nuevoprecio = $precio * $cantidad;
    if ($cantidad == 0) {

      $this->Ventastienda->delete($id);
      $this->Movimiento->delete($idmovimiento);
    } else {
      $data = array('id' => $id, 'cantidad' => $cantidad, 'total' => $nuevoprecio);

      $this->Ventastienda->save($data);
      $this->Movimiento->delete($idmovimiento);
    }

    $fecha = date('Y-m-d');

    $ventas = $this->Ventastienda->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Ventastienda.created' => $fecha,
        'Ventastienda.pedidotemporal' => 1
      ),
      'group' => array('Ventastienda.producto_id')
    ));
    $cantidades = $this->Ventastienda->find('all', array(
      'conditions' => array('Ventastienda.created' => $fecha,
        'Ventastienda.pedidotemporal' => 1),
      'fields' => array(
        'sum(Ventastienda.cantidad) as cantidad',
        'sum(Ventastienda.total) as total'
    )));

    $this->set(compact('ventas', 'cantidades'));
  }

  public function index() {
    $idAlmacen = $this->get_id_almacen();
    $sql = "SELECT tot.total FROM totales tot WHERE tot.almacene_id = $idAlmacen AND tot.producto_id = Productosprecio.producto_id LIMIT 1";
    $this->Productosprecio->virtualFields = array(
      'total' => "CONCAT(($sql))",
      'marca' => "(SELECT ma.nombre FROM marcas ma WHERE ma.id = Producto.marca_id)"
    );
    $productos = $this->Productosprecio->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Productosprecio.escala' => 'TIENDA',
        'Productosprecio.tipousuario_id' => 2,
        'Producto.id !=' => null
      ),
      'fields' => array('Productosprecio.*', 'Producto.*')
    ));
    //debug($productos);exit;
    $categorias = $this->Tiposproducto->find('all', array('recursive' => -1, 'conditions' => array('Tiposproducto.nombre !=' => 'CELULARES')));
    //debug($categorias); exit;       
    $this->set(compact('productos', 'categorias'));
  }

  public function cerrarventa() {
    $fecha = date('Y-m-d');

    $ventas = $this->Ventastienda->find('all', array(
      'recursive' => 0,
      'conditions' => array(
        'Ventastienda.created' => $fecha,
        'Ventastienda.pedidotemporal' => 1),
      'group' => array('Ventastienda.producto_id')
    ));

    foreach ($ventas as $v) {
      $id = $v['Ventastienda']['id'];
      $data = array('id' => $id, 'pedidotemporal' => 2);


      $this->Ventastienda->save($data);
    }
    $this->Session->setFlash('Venta registrada', 'msgbueno');
    $dato = $ventas;
    $this->redirect(array('action' => 'index'));
  }

  function pidecodigo() {
    if (!empty($this->request->data)) {

      $codigo = $this->request->data['Cliente']['codigo'];

      $cliente = $this->Cliente->find('first', array(
        'conditions' => array(
          'Cliente.num_registro' => $codigo
      )));
      if (!empty($cliente)) {
        $idCliente = $cliente['Cliente']['id'];
        $this->redirect(array('action' => 'formulario', $idCliente));
      } else {
        $this->Session->setFlash('No existe el cliente con codigo de registro: ' . $codigo .
          ', consulte al administrador del sistema', 'msgerror');
        $this->redirect(array('action' => 'pidecodigo'), null, true);
      }
    }
  }

  function formulario($id_cli = null, $num_trans = null) {

    $usu = $this->Session->read('Auth.User.id');
    $sucursal = $this->Session->read('Auth.User.sucursal_id');

    $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.sucursal_id' => $sucursal)));

    $idAlmacen = $almacen['Almacene']['id'];

    $datoscli = $this->Cliente->findById($id_cli);

    $precios = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 2,
        //'Producto.proveedor like' => 'VIVA',
        'Productosprecio.escala' => 'MAYOR',
        'Producto.estado' => '1'),
      'order' => array('Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
        'Productosprecio.escala')));
    //debug($precios);exit;
    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 2,
        //'Producto.proveedor like' => 'VIVA',
        'Productosprecio.escala' => 'MAYOR',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));
    if ($this->Session->check('form_venta_mayor')) {
      $this->request->data = $this->Session->read('form_venta_mayor');
      $this->Session->delete('form_venta_mayor');
    }
    //debug($precios);exit;
    $this->set(compact('precios', 'rows', 'idAlmacen', 'usu', 'datoscli', 'sucursal', 'recargas', 'num_trans'));
  }

  public function registra_venta_mayor($idAlmacen = null) {
    /* debug($this->request->data);
      exit; */
    foreach ($this->request->data['Movimiento'] as $dat) {
      $total = $this->get_total($dat['producto_id'], 1, $idAlmacen);
      if ($dat['salida'] > 0) {
        if ($dat['salida'] > $total) {
          $this->Session->write('form_venta_mayor', $this->request->data);
          $this->Session->setFlash('Solo hay ' . $total . ' unidades de ' . $dat['nombre_prod'] . '!!!', 'msgerror');
          $this->redirect(array('action' => 'formulario', $this->request->data['Ventastienda']['cliente_id']));
        }
      }
    }
    $num_transaccion = $this->get_num_trans();
    foreach ($this->request->data['Movimiento'] as $dat) {

      $total = $this->get_total($dat['producto_id'], 1, $idAlmacen);
      $this->Movimiento->create();
      //$dat['total'] = $total - $dat['salida'];
      $dat['transaccion'] = $num_transaccion;
      $this->Movimiento->save($dat);
      if (!empty($dat['id'])) {
        $total = $total + $dat['salida_ant'];
      }
      $this->set_total($dat['producto_id'], 1, $idAlmacen, ($total - $dat['salida']));
    }
    //$this->registra_recarga();
    $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
    $this->redirect(array('action' => 'clientes'));
  }

  public function registra_recarga() {
    $recargas = $this->request->data['Recarga'];
    if (!empty($recargas)) {
      foreach ($recargas as $data) {
        if (!empty($data['monto'])) {
          //debug($data);
          $this->Recarga->create();
          $this->Recarga->save($data);
        }
      }
    }
  }

//fin formulario

  public function reporteventasxmayorproductos() {
    $this->layout = "imprimetabla";
    $fecha = date('Y-m-d');
    $sucursal = $this->Session->read('Auth.User.sucursal_id');
    //debug($sucursal);
    $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.sucursal_id' => $sucursal)));
    $idAlmacen = $almacen['Almacene']['id'];
    //debug($idAlmacen);
    //debug($almacen);exit;
    $nombre = $this->Session->read('Auth.User.Sucursal.nombre');

    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));

    $fech = $fecha . '%';
    $recargas = $this->Recarga->find('all', array(
      'conditions' => array('Recarga.sucursal_id' => $sucursal, 'Recarga.created like' => $fech)
    ));

    $deposito = $this->Deposito->find('first', array(
      'conditions' => array('Deposito.created' => $fecha, 'Deposito.sucursal_id' => $sucursal)
    ));
    $this->set(compact('nombre', 'hora', 'fecha', 'rows', 'precios', 'idAlmacen', 'recargas', 'deposito', 'sucursal'));
  }

  public function reporte149($sucursal = null, $hoy = null) {
    $this->layout = "imprimetabla";
    $usuario_id = $this->Session->read('Auth.User.id');

    $datossucursal = $this->Sucursal->find(
      'first', array(
      'conditions' => array('Sucursal.id' => $sucursal),
      'recursive' => -1));

    $nombre = $datossucursal['Sucursal']['nombre'];
    if (empty($hoy)) {
      $hoy = date('Y-m-d');
    }

    $dia = $hoy;
    $precios = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'order' => array('Producto.id ASC', 'Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
        'Productosprecio.escala')));

    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));

    $ventas = $this->Ventastienda->find('all', array(
      'conditions' => array(
        'Ventastienda.created' => $hoy,
        'Ventastienda.cliente_id !=' => NULL
      ),
      'order' => array('Ventastienda.cliente_id ASC', 'Ventastienda.producto_id ASC', 'Ventastienda.precio DESC')));
    //debug($ventas);exit;
    $clientes = $this->Ventastienda->find('all', array(
      'conditions' => array(
        'Ventastienda.created' => $hoy,
        'Ventastienda.cliente_id !=' => NULL
      ),
      'group' => array('Ventastienda.cliente_id'),
      'order' => array('Ventastienda.cliente_id ASC')
    ));

    $hoy = $hoy . ' %';

    $recargas = $this->Recarga->find('all', array(
      'conditions' => array(
        'Recarga.created LIKE' => $hoy,
        'Recarga.sucursal_id' => $sucursal)));

    $deposito = $this->Deposito->find('first', array(
      'conditions' => array('Deposito.created' => $hoy, 'Deposito.sucursal_id' => $sucursal)
    ));

    $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'nombre', 'deposito', 'sucursal'));
  }

  public function registrardeposito() {
    if (!empty($this->request->data)) {
      $this->Deposito->create();
      if ($this->Deposito->save($this->request->data)) {
        $this->Session->setFlash('deposito registrado', 'msgbueno');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('deposito registrado', 'msgbueno');
        $this->redirect(array('action' => 'registrardeposito'));
      }
    }
  }

  public function cambiopass($id = null) {
    $this->User->id = $id;
    if (!$id) {
      $this->Session->setFlash('No existe tal registro');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->User->read();
    } else {
      if ($this->User->save($this->data)) {
        $this->Session->setFlash('Su Password fue modificado Exitosamente');
        $this->redirect(array('action' => 'index'), null, true);
      } else {
        $this->Session->setFlash('no se pudo modificar!!');
      }
    }
  }

  public function registrocabinas() {
    if (!empty($this->request->data)) {

      $sucursal = $this->request->data['Movimientoscabina']['sucursal_id'];
      $tipo = $this->request->data['Movimientoscabina']['tipo'];
      if ($tipo == 1) {
        $cantidad = $this->request->data['Movimientoscabina']['cantidad'];
        $producto = $this->request->data['Movimientoscabina']['producto_id'];
        $datoscarga = $this->Recargascabina->find('first', array('Recargascabina.producto_id' => $producto));

        $datos = $this->Producto->find('first', array('conditions' => array('Producto.id' => $producto)));
        $nombreproducto = $datos['Producto']['nombre'];
        $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.sucursal_id' => $sucursal)));
        $idAlmacen = $almacen['Almacene']['id'];
        $usu = $this->Session->read('Auth.User.id');
        $movs = $this->Movimiento->find('all', array(
          'conditions' => array(
            'Movimiento.almacene_id' => $idAlmacen,
            'Movimiento.producto_id' => $producto),
          'fields' => array('MAX(Movimiento.id) as id')
        ));

        if (!empty($movs)) {
          $id = $movs['0']['0']['id'];
          $movimiento = $this->Movimiento->find('first', array(
            'conditions' => array('Movimiento.id' => $id),
            'recursive' => -1));

          if ($movimiento['Movimiento']['total'] != 0 && $movimiento['Movimiento']['total'] >= $cantidad) {
            $saldo = $movimiento['Movimiento']['total'] - $cantidad;
            $fecha = date('Y-m-d');
            if ($fecha == $movimiento['Movimiento']['created']) {
              $ingreso = $movimiento['Movimiento']['ingreso'];
              $cantidadsalida = $movimiento['Movimiento']['salida'] + $cantidad;
            } else {
              $ingreso = 0;
              $cantidadsalida = $cantidad;
            }
            $total = $movimiento['Movimiento']['total'] - $cantidad;

            $this->Movimiento->create();

            $this->request->data['Movimiento']['producto_id'] = $producto;
            $this->request->data['Movimiento']['user_id'] = $usu;
            $this->request->data['Movimiento']['almacene_id'] = $idAlmacen;
            $this->request->data['Movimiento']['ingreso'] = $ingreso;
            $this->request->data['Movimiento']['saldo'] = $saldo;
            $this->request->data['Movimiento']['salida'] = $cantidadsalida;
            $this->request->data['Movimiento']['total'] = $total;


            //debug($this->request->data['Movimiento']);exit;
            if (!($this->Movimiento->save($this->request->data['Movimiento']))) {
              $this->Session->setFlash('Error en el registro (movimiento)', 'msgerror');
              $this->redirect(array('action' => 'registrocabinas'));
            } else {
              $this->Movimientoscabina->create();

              $cabina = $this->request->data['Movimientoscabina']['cabina_id'];
              $cargas = $this->Movimientoscabina->find('first', array(
                'conditions' => array('Movimientoscabina.cabina_id' => $cabina, 'Movimientoscabina.created' => $fecha)
              ));
              $montocarga = $datoscarga['Recargascabina']['monto'];
              $montorecarga = $datoscarga['Recargascabina']['monto_recarga'];

              if (!empty($cargas)) {
                $total = $cargas['Movimientoscabina']['total'] + $montorecarga;
                $saldo = $cargas['Movimientoscabina']['saldo'];
              } else {
                $total = $montorecarga + $cargas['Movimientoscabina']['saldo'];

                $cargas = $this->Movimientoscabina->find('first', array(
                  'conditions' => array('Movimientoscabina.cabina_id' => $cabina),
                  'order' => array('Movimientoscabina.id DESC')
                ));

                $saldo = $cargas['Movimientoscabina']['saldo'];
              }
              $this->request->data['Movimientoscabina']['montocarga'] = $montorecarga;
              $this->request->data['Movimientoscabina']['saldo'] = $saldo;
              $this->request->data['Movimientoscabina']['total'] = $total;

              if ($this->Movimientoscabina->save($this->request->data['Movimientoscabina'])) {
                $this->Session->setFlash('Recaraga registrada', 'msgbueno');
                $this->redirect(array('action' => 'index'));
              } else {
                $this->Session->setFlash('Error en registro', 'msgerror');
                $this->redirect(array('action' => 'index'));
              }
            }
          } else {
            $this->Session->setFlash('No le quedan o no tiene suficientes ' . $nombreproducto, 'msgerror');
            $this->redirect(array('action' => 'index'));
          }
        } else {

          $this->Session->setFlash('Error en registro no tiene ' . $nombreproducto, 'msgerror');
          $this->redirect(array('action' => 'index'));
        }
      } else {

        $cabina = $this->request->data['Movimientoscabina']['cabina_id'];
        $cargas = $this->Movimientoscabina->find('first', array(
          'conditions' => array('Movimientoscabina.cabina_id' => $cabina),
          'order' => array('Movimientoscabina.id DESC')
        ));
        $data = array('id' => $cargas['Movimientoscabina']['id'], 'saldo' => $this->request->data['Movimientoscabina']['saldo']);

        if ($this->Movimientoscabina->save($data)) {
          $this->Session->setFlash('Registro correcto', 'msgbueno');
          $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash('Error en registro', 'msgerror');
          $this->redirect(array('action' => 'index'));
        }
      }
    }

    $cabinas = $this->Cabina->find('all', array(
      'conditions' => array('Cabina.sucursal_id' => $this->Session->read('Auth.User.sucursal_id')),
      'recursive' => -1));
    $tarjetas = $this->Recargascabina->find('all', array('recursive' => 1));
    //debug($tarjetas);exit;
    $this->set(compact('cabinas', 'tarjetas'));
  }

  public function reporteventashoy($idsucursal = null) {
    $this->layout = "imprimetabla";
    $fecha = date('Y-m-d');

    $cabinas = $this->Movimientoscabina->find('all', array('conditions' => array('Movimientoscabina.created' => $fecha)));

    $sucursal = $this->Sucursal->find('first', array('conditions' => array('Sucursal.id' => $idsucursal)));
    $nombre = $sucursal['Sucursal']['nombre'];
    $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.sucursal_id' => $idsucursal)));

    $idAlmacen = $almacen['Almacene']['id'];

    $rows = $this->Ventastienda->find('all', array(
      'conditions' => array(
        'Ventastienda.created' => $fecha,
        'Ventastienda.pedidotemporal' => 2),
      'group' => array('Ventastienda.producto_id'),
    ));
    //debug($idsucursal);
    $this->set(compact('rows', 'cabinas', 'nombre', 'fecha', 'idAlmacen', 'idsucursal'));
  }

  public function reporteventastienda($idsucursal = null, $fecha = null) {
    $this->layout = "imprimetabla";

    if (empty($fecha)) {
      $fecha = date('Y-m-d');
    }
    $cabinas = $this->Movimientoscabina->find('all', array('conditions' => array('Movimientoscabina.created' => $fecha)));
    $sucursal = $this->Sucursal->find('first', array('conditions' => array('Sucursal.id' => $idsucursal)));
    $nombre = $sucursal['Sucursal']['nombre'];
    $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.sucursal_id' => $idsucursal)));
    $idAlmacen = $almacen['Almacene']['id'];
    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array('Productosprecio.escala' => 'TIENDA'),
      'group' => array('Productosprecio.producto_id')
    ));
    $this->set(compact('rows', 'cabinas', 'nombre', 'fecha', 'idAlmacen', 'idsucursal'));
  }

  public function report_may_xproduct() {
    
  }

  public function clientes() {
    if ($this->RequestHandler->responseType() == 'json') {
      $asignar = '<button class="button blue-gradient compact icon-list" type="button" onclick="asignar(' . "',Cliente.id,'" . ')">Asignar</button>';
      $venta = '<button class="button green-gradient compact icon-list" type="button" onclick="venta(' . "',Cliente.id,'" . ')">Venta</button>';
      $acciones = "$asignar $venta";
      $this->Cliente->virtualFields = array(
        'acciones' => "CONCAT('$acciones')"
      );
      $rutas_usuario = $this->Rutasusuario->find('list', array(
        'conditions' => array('Rutasusuario.user_id' => $this->Session->read('Auth.User.id')),
        'fields' => array('Rutasusuario.ruta_id')
      ));
      $this->paginate = array(
        'fields' => array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Cliente.zona', 'Cliente.acciones'),
        'recursive' => -1,
        'order' => 'Cliente.id DESC',
        'conditions' => array('Cliente.ruta_id' => $rutas_usuario)
      );
      $this->DataTable->fields = array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Cliente.zona', 'Cliente.acciones');
      //$this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('clientes', $this->DataTable->getResponse('Tiendas', 'Cliente'));
      $this->set('_serialize', 'clientes');
    }
  }

  public function reportes_tienda() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $datos = array();
    /* debug($fecha_ini);
      debug($fecha_fin);exit; */
    $sucursal = $this->Session->read('Auth.User.sucursal_id');
    $almacen = $this->Almacene->find('first', array(
      'recursives' => -1,
      'conditions' => array('Almacene.sucursal_id' => $sucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $almacen['Almacene']['id'];
    if (!empty($this->request->data['Dato'])) {
      $condiciones = array();
      $condiciones['Movimiento.almacene_id'] = $idAlmacen;
      $condiciones['Movimiento.created >='] = $fecha_ini;
      $condiciones['Movimiento.created <='] = $fecha_fin;
      $condiciones['Movimiento.salida !='] = NULL;
      if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
        $condiciones['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
      }
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Producto.id'] = $this->request->data['Dato']['producto_id'];
      }

      $sql1 = "(SELECT IF(ISNULL(SUM(mo.salida)),0,SUM(mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'TIENDA' AND Producto.id = mo.producto_id)";
      $sql2 = "(SELECT IF(ISNULL(SUM(mo.salida)),0,SUM(mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'MAYOR' AND Producto.id = mo.producto_id)";
      $sql3 = "(SELECT IF(ISNULL(SUM(mo.precio_uni*mo.salida)),0,SUM(mo.precio_uni*mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'TIENDA' AND Producto.id = mo.producto_id)";
      $sql4 = "(SELECT IF(ISNULL(SUM(mo.precio_uni*mo.salida)),0,SUM(mo.precio_uni*mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'MAYOR' AND Producto.id = mo.producto_id)";

      $sql6 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql5 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE mov.almacene_id = $idAlmacen AND mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $this->Movimiento->virtualFields = array(
        'ventas' => "CONCAT($sql1)",
        'ventas_mayor' => "CONCAT($sql2)",
        'precio_v_t' => "CONCAT($sql3)",
        'precio_v_mayor' => "CONCAT($sql4)",
        'total_s' => "CONCAT($sql6-(IF(ISNULL($sql5),0,$sql5)))"
      );
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones,
        'group' => array('Movimiento.producto_id'),
        'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.ventas', 'Movimiento.ventas_mayor', 'Movimiento.precio_v_t', 'Movimiento.precio_v_mayor', 'Movimiento.total_s')
      ));
      /* debug($datos);
        exit; */
    }
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $this->set(compact('datos', 'categorias'));
  }

  public function ajax_l_productos($idTipoprod = null) {
    $this->layout = 'ajax';
    /* debug($idTipoprod);
      exit; */
    $productos = $this->Producto->find('list', array('fields' => 'nombre', 'conditions' => array('Producto.tiposproducto_id' => $idTipoprod)));
    $this->set(compact('productos'));
  }

  public function reporte_detallado_precio() {

    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $sucursal = $this->Session->read('Auth.User.sucursal_id');
    $almacen = $this->Almacene->find('first', array(
      'recursives' => -1,
      'conditions' => array('Almacene.sucursal_id' => $sucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $almacen['Almacene']['id'];
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $condiciones = array();
      $condiciones['Movimiento.almacene_id'] = $idAlmacen;
      $condiciones['Movimiento.created >='] = $fecha_ini;
      $condiciones['Movimiento.created <='] = $fecha_fin;
      $condiciones['Movimiento.salida !='] = NULL;
      if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
        $condiciones['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
      }
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Producto.id'] = $this->request->data['Dato']['producto_id'];
      }
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE mov.almacene_id = $idAlmacen AND mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $this->Movimiento->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
      );
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones,
        'group' => array('Movimiento.producto_id'),
        'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.total_s')
      ));
      foreach ($datos as $key => $da) {
        $datos_aux = $this->Movimiento->find('all', array(
          'recursive' => -1, 'order' => 'Movimiento.producto_id',
          'conditions' => array('Movimiento.almacene_id' => $idAlmacen, 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.producto_id' => $da['Producto']['id']),
          'group' => array('Movimiento.precio_uni'),
          'fields' => array('SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total', 'Movimiento.producto_id')
        ));
        $datos[$key]['precios'] = $datos_aux;
        //debug($datos);exit;
      }
    }
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $this->set(compact('datos', 'categorias'));
  }

  public function reporte_cliente() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $sucursal = $this->Session->read('Auth.User.sucursal_id');
    $almacen = $this->Almacene->find('first', array(
      'recursives' => -1,
      'conditions' => array('Almacene.sucursal_id' => $sucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $almacen['Almacene']['id'];
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $condiciones = array();
      $condiciones['Movimiento.almacene_id'] = $idAlmacen;
      $condiciones['Movimiento.created >='] = $fecha_ini;
      $condiciones['Movimiento.created <='] = $fecha_fin;
      $condiciones['Movimiento.cliente_id !='] = NULL;
      if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
        $condiciones['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
      }
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Producto.id'] = $this->request->data['Dato']['producto_id'];
      }
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones,
        'group' => array('Movimiento.cliente_id'),
        'fields' => array('Cliente.nombre', 'Cliente.num_registro', 'Movimiento.cliente_id', 'SUM(Movimiento.salida) ventas', 'SUM(Movimiento.precio_uni*Movimiento.salida)')
      ));
      foreach ($datos as $key => $da) {
        $datos_aux = $this->Movimiento->find('all', array(
          'recursive' => 0, 'order' => 'Movimiento.producto_id',
          'conditions' => array('Movimiento.almacene_id' => $idAlmacen, 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.cliente_id' => $da['Movimiento']['cliente_id'], 'Movimiento.salida !=' => 'null'),
          'group' => array('Movimiento.producto_id', 'Movimiento.precio_uni'),
          'fields' => array('Producto.nombre', 'SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total')
        ));
        $datos[$key]['productos'] = $datos_aux;
      }
      //($datos);exit;
    }
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $this->set(compact('datos', 'categorias'));
  }

  public function chips($idCliente = null) {
    $cliente = $this->Cliente->find('first', array('recursive' => -1, 'fields' => array('Cliente.nombre'), 'conditions' => array('Cliente.id' => $idCliente)));

    if ($this->RequestHandler->responseType() == 'json') {
      $this->paginate = array(
        'fields' => array('Chip.id', 'Chip.cantidad', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha'),
        'recursive' => 0,
        'order' => 'Chip.created'
        , 'conditions' => array('Chip.distribuidor_id' => $this->Session->read('Auth.User.id'), 'Chip.cliente_id' => NULL)
      );
      $this->DataTable->fields = array('Chip.id', 'Chip.cantidad', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha');
      $this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('chips', $this->DataTable->getResponse('Tiendas', 'Chip'));
      $this->set('_serialize', 'chips');
    }
    $this->set(compact('cliente', 'idCliente'));
  }

  public function registra_asignado() {
    $datos = $this->request->data['Dato'];
    if (!empty($datos['rango_ini']) && !empty($datos['cantidad'])) {
      $chips = $this->Chip->find('all', array(
        'recursive' => -1,
        'order' => 'Chip.id', 'limit' => $datos['cantidad'], 'fields' => array('Chip.id'),
        'conditions' => array('Chip.id >=' => $datos['rango_ini'], 'Chip.distribuidor_id' => $this->Session->read('Auth.User.id'))
      ));
      foreach ($chips as $ch) {
        $this->Chip->id = $ch['Chip']['id'];
        $dato['Chip']['cliente_id'] = $datos['cliente_id'];
        $this->Chip->save($dato['Chip']);
      }
      $this->Session->setFlash('Se asigno correctamente', 'msgbueno');
    } else {
      $this->Session->setFlash('No se pudo registrar', 'msgerror');
    }
    $this->redirect(array('action' => 'chips', $datos['cliente_id']));
  }

  public function lista_celulares() {
    $idSucursal = $this->Session->read('Auth.User.sucursal_id');
    $Almacen = $this->Almacene->find('first', array(
      'recursive' => -1,
      'conditions' => array('Almacene.sucursal_id' => $idSucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $Almacen['Almacene']['id'];
    //debug($idAlmacen);exit;
    if ($this->RequestHandler->responseType() == 'json') {
      $tipo_pro_cel = $this->Tiposproducto->findBynombre('CELULARES', null, null, -1);
      $comillas = '"' . "'" . '"';
      $add = '<button class="button green-gradient compact icon-plus" type="button" onclick="add_venta(' . "',Producto.id,',',$comillas ,Producto.nombre,$comillas ,' " . ",',Productosprecio.precio,'" . ')"><span class="icon-cart"></span></button>';
      $acciones = "$add";
      $sql = "SELECT t.total FROM totales t WHERE t.producto_id = Producto.id AND t.almacene_id = $idAlmacen LIMIT 1";
      $sql1 = "SELECT nombre FROM marcas WHERE id = Producto.marca_id";
      $this->Productosprecio->virtualFields = array(
        'imagen' => "CONCAT(IF(ISNULL(Producto.url_imagen),'',CONCAT('" . '<img src="../' . "',Producto.url_imagen,'" . '" height="51" width="51">' . "')))",
        'cantidad' => "$sql",
        'marca' => "$sql1",
        'acciones' => "CONCAT('$acciones')"
      );
      /* debug($id_a);
        exit; */
      $this->paginate = array(
        'fields' => array('Productosprecio.imagen', 'Producto.nombre', 'Productosprecio.marca', 'Productosprecio.cantidad', 'Productosprecio.precio', 'Productosprecio.acciones'),
        'recursive' => 0,
        'order' => 'Producto.nombre DESC',
        'conditions' => array('Productosprecio.escala' => 'TIENDA', 'Producto.tiposproducto_id' => $tipo_pro_cel['Tiposproducto']['id'])
      );
      //debug($idAlmacen);exit;
      $this->set('productosprecio', $this->DataTable->getResponse('Tiendas', 'Productosprecio'));
      $this->set('_serialize', 'productosprecio');
    }
    $this->set(compact('idAlmacen'));
  }

  public function registra_venta_celu($idAlmacen = null) {
    /* debug($idAlmacen);
      exit; */
    foreach ($this->request->data['productos'] as $key => $ped) {
      //$total = $this->get_total_cel_almacen($key);
      $total = $this->get_total($key, 1, $idAlmacen);
      if ($ped['cantidad'] > $total) {
        $this->Session->setFlash('No se pudo registrar verifique las cantidades antes!!!', 'msgerror');
        $this->redirect(array('action' => 'lista_celulares'));
      }
    }
    $celulares = array();
    $i = 0;
    foreach ($this->request->data['productos'] as $key => $ped) {
      for ($j = 1; $j <= $ped['cantidad']; $j++) {
        $producto = $this->Producto->find('first', array(
          'conditions' => array('Producto.id' => $key)
          , 'fields' => array('Producto.nombre', 'Producto.url_imagen', 'Marca.nombre', 'Producto.observaciones', 'Producto.id')
        ));
        $celulares[$i] = $producto;
        $celulares[$i]['precio'] = $ped['precio'];
        $i++;
      }
    }
    $this->set(compact('celulares'));
  }

  public function get_total_cel_almacen($idProducto = null) {
    $movimiento = $this->Ventascelulare->find('first', array(
      'order' => 'Ventascelulare.id DESC',
      'conditions' => array('Ventascelulare.almacene_id' => $this->get_id_almacen(), 'Ventascelulare.producto_id' => $idProducto)
    ));
    /* debug($movimiento);
      exit; */
    if (!empty($movimiento)) {
      return $movimiento['Ventascelulare']['total'];
    } else {
      return 0;
    }
  }

  public function registra_venta_celu_2() {
    /* debug($this->request->data);
      exit; */
    $this->Sucursal->id = $this->Session->read('Auth.User.sucursal_id');
    $this->Sucursal->save($this->request->data['Sucursal']);
    $idAlmacen = $this->get_id_almacen();
    $num_trans = $this->get_num_trans_cel();
    foreach ($this->request->data['Ventascelulare'] as $da) {
      //$total_u = $this->get_total_cel_almacen($da['producto_id']);
      $total_u = $this->get_total($da['producto_id'], 1, $idAlmacen);
      $datos['Ventascelulare'] = $da;
      //$datos['Ventascelulare']['total'] = $total_u - 1;
      $datos['Ventascelulare']['salida'] = 1;
      $datos['Ventascelulare']['user_id'] = $this->Session->read('Auth.User.id');
      $datos['Ventascelulare']['almacene_id'] = $idAlmacen;
      $datos['Ventascelulare']['sucursal_id'] = $this->Session->read('Auth.User.sucursal_id');
      $datos['Ventascelulare']['tipo_cambio'] = $this->request->data['Sucursal']['tipo_cambio'];
      $datos['Ventascelulare']['transaccion'] = $num_trans;
      $this->Ventascelulare->create();
      $this->Ventascelulare->save($datos['Ventascelulare']);
      $this->set_total($da['producto_id'], 1, $idAlmacen, $total_u - 1);
      $idVenta = $this->Ventascelulare->getLastInsertID();
      foreach ($da['Pago'] as $pa) {
        $this->request->data['Pago'] = $pa;
        $this->request->data['Pago']['ventascelulare_id'] = $idVenta;
        $this->Pago->create();
        $this->Pago->save($this->request->data['Pago']);
      }
    }
    $this->Session->setFlash('Se registro correctamente la venta!!!', 'msgbueno');
    $this->redirect(array('action' => 'lista_celulares'));
  }

  public function reporte_pagos() {
    $datos = array();
    if (!empty($this->request->data)) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $tipo = $this->request->data['Dato']['tipo'];
      $condiciones = array();
      $condiciones['Pago.created >='] = $fecha_ini;
      $condiciones['Pago.created <='] = $fecha_fin;
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $this->Session->read('Auth.User.sucursal_id')),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];
      $condiciones['Ventascelulare.almacene_id'] = $idAlmacen;
      if ($tipo != 'Todos') {
        $condiciones['Pago.tipo'] = $tipo;
      }

      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Ventascelulare.producto_id'] = $this->request->data['Dato']['producto_id'];
      }
      $sql = "SELECT p.nombre FROM productos p WHERE p.id = Ventascelulare.producto_id";
      $this->Pago->virtualFields = array(
        'producto' => "CONCAT(($sql))"
      );
      $datos = $this->Pago->find('all', array(
        'recursive' => 0,
        'conditions' => $condiciones,
        'fields' => array('Ventascelulare.cliente', 'Pago.producto', 'Pago.monto', 'Pago.tipo', 'Pago.codigo', 'Ventascelulare.producto_id', 'Pago.created')
      ));
      /* debug($datos);
        exit; */
    }
    $productos = $this->Producto->find('list', array(
      'fields' => array('id', 'nombre'),
      'conditions' => array('tipo_producto' => 'CELULARES')
    ));
    $this->set(compact('datos', 'productos'));
  }

  public function reporte_celular() {
    $datos = array();
    if (!empty($this->request->data)) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $sucursal = $this->Session->read('Auth.User.sucursal_id');
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $sucursal),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];

      $condiciones = array();
      $condiciones['Ventascelulare.almacene_id'] = $idAlmacen;
      $condiciones['DATE(Ventascelulare.created) >='] = $fecha_ini;
      $condiciones['DATE(Ventascelulare.created) <='] = $fecha_fin;
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Producto.id'] = $this->request->data['Dato']['producto_id'];
      }
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.entrada)+SUM(mov.salida)) FROM ventascelulares mov WHERE mov.almacene_id = $idAlmacen AND DATE(mov.created) > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $this->Ventascelulare->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
      );
      $datos = $this->Ventascelulare->find('all', array(
        'recursive' => 0, 'order' => 'Ventascelulare.producto_id',
        'conditions' => $condiciones,
        'group' => array('Ventascelulare.producto_id'),
        'fields' => array('Producto.nombre', 'SUM(Ventascelulare.entrada) entregado', 'SUM(Ventascelulare.salida) vendido', 'Producto.id', 'Ventascelulare.total_s', 'Ventascelulare.precio', 'Ventascelulare.id')
      ));
    }
    $productos = $this->Producto->find('list', array(
      'fields' => array('id', 'nombre'),
      'conditions' => array('tipo_producto' => 'CELULARES')
    ));
    $this->set(compact('datos', 'productos'));
  }

  public function reporte_celular_cliente() {
    $datos = array();
    if (!empty($this->request->data)) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $sucursal = $this->Session->read('Auth.User.sucursal_id');
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $sucursal),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];

      $condiciones = array();
      $condiciones['Ventascelulare.almacene_id'] = $idAlmacen;
      $condiciones['DATE(Ventascelulare.created) >='] = $fecha_ini;
      $condiciones['DATE(Ventascelulare.created) <='] = $fecha_fin;
      $condiciones['Ventascelulare.salida !='] = 0;
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Producto.id'] = $this->request->data['Dato']['producto_id'];
      }
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.entrada)+SUM(mov.salida)) FROM ventascelulares mov WHERE mov.almacene_id = $idAlmacen AND DATE(mov.created) > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $this->Ventascelulare->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
      );

      $datos = $this->Ventascelulare->find('all', array(
        'recursive' => 0, 'order' => 'Ventascelulare.producto_id',
        'conditions' => $condiciones,
        'fields' => array('Producto.nombre', 'Producto.id', 'Ventascelulare.created', 'Ventascelulare.precio', 'Ventascelulare.id', 'Ventascelulare.cliente')
      ));
      foreach ($datos as $key => $da) {
        $datos[$key]['pagos'] = $this->Pago->find('all', array(
          'recursive' => -1,
          'conditions' => array('Pago.ventascelulare_id' => $da['Ventascelulare']['id']),
          'fields' => array('Pago.tipo', 'Pago.monto')
        ));
      }
    }
    $productos = $this->Producto->find('list', array(
      'fields' => array('id', 'nombre'),
      'conditions' => array('tipo_producto' => 'CELULARES')
    ));
    $this->set(compact('datos', 'productos'));
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

  public function get_d_edit_v($num_trans = null, $idProducto = null, $precio = null) {
    $movimiento = $this->Movimiento->find('first', array(
      'recursive' => -1,
      'conditions' => array('Movimiento.transaccion' => $num_trans, 'Movimiento.producto_id' => $idProducto, 'Movimiento.precio_uni' => $precio, 'Movimiento.created' => date("Y-m-d")),
      'fields' => array('Movimiento.id', 'Movimiento.salida')
    ));
    if (!empty($movimiento)) {
      return $movimiento['Movimiento'];
    } else {
      return NULL;
    }
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

  public function ventas() {
    $ventas = $this->Movimiento->find('all', array(
      'conditions' => array('Movimiento.created' => date("Y-m-d"), 'Movimiento.sucursal_id' => $this->Session->read('Auth.User.sucursal_id'), 'Movimiento.escala' => 'MAYOR'),
      'group' => array('Movimiento.transaccion'),
      'fields' => array('Cliente.nombre', 'SUM(Movimiento.precio_uni*Movimiento.salida) as monto_total', 'Movimiento.transaccion', 'Movimiento.cliente_id')
    ));
    //debug($ventas);exit;
    $this->set(compact('ventas'));
  }

  public function ventascelulares() {
    $this->Ventascelulare->virtualFields = array(
      'marca' => "(SELECT marcas.nombre FROM marcas WHERE marcas.id = Producto.marca_id)",
      'color' => "(SELECT colores.nombre FROM colores WHERE colores.id = Producto.colore_id)"
    );
    $ventas = $this->Ventascelulare->find('all', array(
      'conditions' => array('Ventascelulare.sucursal_id' => $this->Session->read('Auth.User.sucursal_id')),
      //'group' => array('Ventascelulare.transaccion'),
      'fields' => array('Producto.nombre', 'Ventascelulare.id', 'Ventascelulare.marca', 'Ventascelulare.color', 'Ventascelulare.created', 'Ventascelulare.cliente', 'Ventascelulare.precio', 'Ventascelulare.transaccion'),
      'order' => array('Ventascelulare.created DESC')
    ));
    //debug($ventas);exit;
    $this->set(compact('ventas'));
  }

  public function ventastienda() {
    $ventas = $this->Movimiento->find('all', array(
      'conditions' => array('Movimiento.created' => date("Y-m-d"), 'Movimiento.sucursal_id' => $this->Session->read('Auth.User.sucursal_id'), 'Movimiento.escala' => 'TIENDA'),
      'group' => array('Movimiento.transaccion'),
      'fields' => array('Movimiento.created', 'SUM(Movimiento.precio_uni*Movimiento.salida) as monto_total', 'Movimiento.transaccion'),
      'order' => array('Movimiento.transaccion DESC')
    ));
    //debug($ventas);exit;
    $this->set(compact('ventas'));
  }

  public function detalle_venta_t($transaccion = null) {
    $this->Movimiento->virtualFields = array(
      'marca' => "(SELECT ma.nombre FROM marcas ma WHERE ma.id = Producto.marca_id)"
    );
    $items = $this->Movimiento->find('all', array(
      'conditions' => array('Movimiento.sucursal_id' => $this->Session->read('Auth.User.sucursal_id'), 'Movimiento.escala' => 'TIENDA', 'Movimiento.transaccion' => $transaccion),
      'fields' => array('Movimiento.id', 'Producto.nombre', 'Producto.tipo_producto', 'Movimiento.marca', 'Movimiento.salida', '(Movimiento.precio_uni*Movimiento.salida) as mon_total', 'Movimiento.salida', 'Movimiento.precio_uni', 'Movimiento.marca')
    ));
    $this->set(compact('items', 'transaccion'));
  }

  public function report_control_ven() {
    $datos_array = array();
    if (!empty($this->request->data)) {
      $idSucursal = $this->Session->read('Auth.User.sucursal_id');
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $this->Ventascelulare->virtualFields = array(
        'prod_marca' => "(SELECT ma.nombre FROM marcas ma WHERE ma.id = Producto.marca_id)",
        'voucher' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Voucher" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)',
        'ticket' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Ticket" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)',
        'efectivo' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Efectivo" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)',
        'tarjeta' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Tarjeta" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)'
      );
      $condiciones = array();
      $condiciones['DATE(Ventascelulare.modified) >='] = $fecha_ini;
      $condiciones['DATE(Ventascelulare.modified) <='] = $fecha_fin;
      $condiciones['DATE(Ventascelulare.modified) <='] = 'CELULARES';
      $condiciones['Almacene.sucursal_id'] = $idSucursal;
      $condiciones['Ventascelulare.salida >'] = 0;
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Ventascelulare.producto_id'] = $this->request->data['Dato']['producto_id'];
      }
      $datos_array = $this->Ventascelulare->find('all', array(
        'recursive' => 0,
        'conditions' => array(
          'DATE(Ventascelulare.modified) >=' => $fecha_ini,
          'DATE(Ventascelulare.modified) <=' => $fecha_fin,
          'Producto.tipo_producto' => 'CELULARES',
          'Almacene.sucursal_id' => $idSucursal,
          'Ventascelulare.salida >' => 0
        ),
        'fields' => array('Producto.nombre', 'Ventascelulare.prod_marca', 'Ventascelulare.voucher', 'Ventascelulare.ticket', 'Ventascelulare.efectivo', 'Ventascelulare.tarjeta', 'Ventascelulare.cliente')
      ));
    }
    $productos = $this->Producto->find('list', array(
      'fields' => array('id', 'nombre'),
      'conditions' => array('tipo_producto' => 'CELULARES')
    ));
    $this->set(compact('datos_array', 'productos'));
  }

  public function ajax_img_prod($idProducto = null) {
    $this->layout = 'ajax';
    $producto = $this->Producto->find('first', array(
      'recursive' => -1,
      'conditions' => array('id' => $idProducto),
      'fields' => array('nombre', 'url_imagen', 'observaciones')
    ));
    $this->set(compact('producto'));
  }

  public function elimina_venta_t($idMovimiento = null) {
    $movimiento = $this->Movimiento->find('first', array(
      'recursive' => -1,
      'conditions' => array('id' => $idMovimiento),
      'fields' => array('salida', 'producto_id')
    ));
    $idAlmacen = $this->get_id_almacen();
    $total = $this->get_total($movimiento['Movimiento']['producto_id'], 1, $idAlmacen);
    $this->Movimiento->delete($idMovimiento);
    $this->set_total($movimiento['Movimiento']['producto_id'], 1, $idAlmacen, ($total + $movimiento['Movimiento']['salida']));
    $this->Session->setFlash("Se elimino correctamente las venta!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function ventacelular($idVentacelular = null) {
    
    if(!empty($this->request->data['Ventascelulare'])){
      $this->Ventascelulare->id = $idVentacelular;
      $this->Ventascelulare->save($this->request->data['Ventascelulare']);
      $this->Session->setFlash("Se ha modificado correctamente!!",'msgbueno');
      $this->redirect(array('action' => 'ventascelulares'));
    }
    $this->request->data = $venta = $this->Ventascelulare->findByid($idVentacelular);
    $sucursal = $this->Sucursal->findByid($this->Session->read('Auth.User.sucursal_id'),null,null,-1);
    //debug($sucursal);exit;
    $tipo_cambio = $sucursal['Sucursal']['tipo_cambio'];
    $pagos = $this->Pago->findAllByventascelulare_id($idVentacelular,null,null,null,null,-1);
    $this->set(compact('venta','tipo_cambio','pagos'));
  }
  
  public function registra_pago_v(){
    $this->Pago->create();
    $this->Pago->save($this->request->data['Pago']);
    $this->Session->setFlash('Se ha registrado el pago!!','msgbueno');
    $this->redirect($this->referer());
  }
  
  public function eliminar_pago_v($idPago = null){
    $this->Pago->delete($idPago);
    $this->Session->setFlash("Se ha eliminado correctamente el pago!!",'msgbueno');
    $this->redirect($this->referer());
  }
  
  public function elimina_venta_cel($idVentacelular = null){
    $venta = $this->Ventascelulare->findByid($idVentacelular,null,null,-1);
    
    $total_c = $this->get_total_cel_almacen($venta['Ventascelulare']['producto_id']);
    //$this->set_
  }
}

?>
