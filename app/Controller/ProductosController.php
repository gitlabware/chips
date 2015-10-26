<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

class ProductosController extends AppController {

  public $layout = 'viva';
  public $name = 'Productos';
  public $uses = array('Producto', 'Preciosventa', 'Tiposproducto', 'Marca',
    'Productosprecio', 'Almacene', 'Movimiento', 'Colore',
    'Ventascelulare', 'Totale', 'Excel');
  public $helpers = array('Html', 'Form');
  public $components = array('Session', 'RequestHandler', 'DataTable');

  public function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  //public
  function index() {
    $idAlmacen = $this->get_id_alm_cent();
    if ($this->RequestHandler->responseType() == 'json') {
      $sql = '(SELECT COUNT(id) FROM productosprecios WHERE (productosprecios.producto_id = Producto.id))';
      $editar = '<a href="javascript:" class="button orange-gradient compact icon-pencil" title="Editar" onclick="editar_p(' . "',Producto.id,'" . ')"></a>';
      $precios = '<a href="javascript:" class="button anthracite-gradient compact icon-page-list" title="Precios" onclick="precios_productos(' . "',Producto.id,'" . ')"></a>';
      $ingresar_ap = '<a href="javascript:" class="button green-gradient compact icon-down-fat" title="Ingresar a almacen principal" onclick="ingresar_ap(' . "',Producto.id,'" . ')"></a>';
      $ingresar_a = '<a href="javascript:" class="button blue-gradient compact icon-down-fat" title="Ingresar a almacen" onclick="ingresar_a(' . "',Producto.id,'" . ')"></a>';
      $elimina = '<button class="button red-gradient compact icon-cross-round" type="button" title="eliminar" onclick="elimina_p(' . "',Producto.id,'" . ')"></button>';
      $acciones = "$editar $precios $elimina $ingresar_ap $ingresar_a";
      $small_r = '<small class="tag red-bg" id="idproducto-' . "',Producto.id,'" . '"> ' . "',$sql,'" . ' </small></td>';
      $small_n = '<small class="tag " id="idproducto-' . "',Producto.id,'" . '"> ' . "',$sql,'" . ' </small></td>';
      $this->Producto->virtualFields = array(
        'imagen' => "CONCAT(IF(ISNULL(Producto.url_imagen),'',CONCAT('" . '<img src="' . "',Producto.url_imagen,'" . '" height="51" width="51">' . "')))",
        'precios' => "CONCAT((IF($sql = 0,CONCAT('$small_r'),CONCAT('$small_n'))))",
        'total_aln_cen' => "(SELECT totales.total FROM totales WHERE totales.almacene_id = $idAlmacen AND totales.producto_id = Producto.id)",
        'acciones' => "CONCAT('$acciones')"
      );
      $this->paginate = array(
        'fields' => array('Producto.precios', 'Producto.imagen', 'Producto.tipo_producto', 'Producto.nombre', 'Marca.nombre', 'Colore.nombre', 'Producto.precio_compra', 'Producto.total_aln_cen', 'Producto.acciones'),
        'recursive' => 0,
        'order' => 'Producto.id DESC'
      );
      $this->DataTable->fields = array('Producto.precios', 'Producto.imagen', 'Producto.tipo_producto', 'Producto.nombre', 'Marca.nombre', 'Colore.nombre', 'Producto.precio_compra', 'Producto.total_aln_cen', 'Producto.acciones');
      $this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('productos', $this->DataTable->getResponse());
      $this->set('_serialize', 'productos');
    }
    $this->set(compact('productos'));
  }

  function insertar() {

    if (!empty($this->data)) {
      $this->request->data['Producto']['estado'] = 1;
      $producto = $this->Tiposproducto->find('first', array('conditions' => array('Tiposproducto.id' => $this->request->data['Producto']['tiposproducto_id'])));
      $this->request->data['Producto']['tipo_producto'] = $producto['Tiposproducto']['nombre'];
      $this->request->data['Producto']['fecha_ingreso'] = date('Y-m-d');
      $this->Producto->create();
      /* debug($this->request->data);
        die; */
      if (!empty($this->request->data['Producto']['imagen']['name'])) {
        $url_img = $this->guarda_imagen();
        if (!empty($url_img)) {
          $this->request->data['Producto']['url_imagen'] = $url_img;
        } else {
          $this->Session->setFlash('No se pudo registrar, problemas al cargar la imagen', 'msgerror');
          $this->redirect(array('action' => 'index'), null, true);
        }
      }
      if ($this->Producto->save($this->request->data['Producto'])) {
        $idProducto = $this->Producto->getLastInsertID();
        $this->registra_precio_cantidad($idProducto);
        $this->registra_precio_cantidad2($idProducto);
        $this->Session->setFlash('Producto Registrado', 'msgbueno');
      } else {
        $this->Session->setFlash('No se pudo registrar!!!', 'msgerror');
      }
      $this->redirect(array('action' => 'index'), null, true);
      //debug($valida); exit;
    } //debug($this->data);
    //exit;
    $tiposproductos = $this->Producto->Tiposproducto->find('all', array('recursive' => -1));
    $marcas = $this->Marca->find('list', array('fields' => 'Marca.nombre'));
    $colores = $this->Colore->find('list', array('fields' => 'Colore.nombre'));
    //debug($marcas);exit;
    $this->set(compact('tiposproductos', 'marcas', 'colores'));
  }

  public function registra_precio_cantidad($idProducto = null) {
    if (!empty($this->request->data['Producto']['precio_venta'])) {
      $this->request->data['Productosprecio']['producto_id'] = $idProducto;
      if ($this->request->data['Productosprecio']['escala'] == 'TIENDA') {
        $this->request->data['Productosprecio']['tipousuario_id'] = 2;
        $this->request->data['Productosprecio']['escala_id'] = 3;
      } elseif ($this->request->data['Productosprecio']['escala'] == 'DISTRIBUIDOR') {
        $this->request->data['Productosprecio']['tipousuario_id'] = 3;
        $this->request->data['Productosprecio']['escala_id'] = 1;
        $this->request->data['Productosprecio']['escala'] = 'MAYOR';
      }
      $this->request->data['Productosprecio']['precio'] = $this->request->data['Producto']['precio_venta'];
      $this->request->data['Productosprecio']['fecha'] = date('Y-m-d');
      $this->Productosprecio->create();
      $this->Productosprecio->save($this->request->data['Productosprecio']);
    }
    if (!empty($this->request->data['Producto']['cantidad_central'])) {
      $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.central' => 1), 'fields' => array('Almacene.id', 'Almacene.sucursal_id')));
      $this->set_total($idProducto, 1, $almacen['Almacene']['id'], $this->request->data['Producto']['cantidad_central']);
      $this->request->data['Movimiento']['user_id'] = $this->Session->read('Auth.User.id');
      $this->request->data['Movimiento']['producto_id'] = $idProducto;
      $this->request->data['Movimiento']['ingreso'] = $this->request->data['Producto']['cantidad_central'];
      //$this->request->data['Movimiento']['total'] = $total;
      $this->request->data['Movimiento']['almacene_id'] = $almacen['Almacene']['id'];
      $this->request->data['Movimiento']['sucursal_id'] = $almacen['Almacene']['sucursal_id'];
      $this->request->data['Movimiento']['transaccion'] = $this->get_num_trans();
      $this->Movimiento->create();
      $this->Movimiento->save($this->request->data['Movimiento']);
    }
  }

  public function registra_precio_cantidad2($idProducto = null) {
    if (!empty($this->request->data['Producto']['precio_ven'])) {
      $this->request->data['Productosprecio']['producto_id'] = $idProducto;
      $this->request->data['Productosprecio']['escala_id'] = 3;
      $this->request->data['Productosprecio']['escala'] = 'TIENDA';
      $this->request->data['Productosprecio']['tipousuario_id'] = 2;
      $this->request->data['Productosprecio']['precio'] = $this->request->data['Producto']['precio_ven'];
      $this->request->data['Productosprecio']['fecha'] = date('Y-m-d');
      $this->Productosprecio->create();
      $this->Productosprecio->save($this->request->data['Productosprecio']);
    }
    if (!empty($this->request->data['Producto']['cantidad_cen'])) {
      $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.central' => 1), 'fields' => array('Almacene.id', 'Almacene.sucursal_id')));
      $this->set_total($idProducto, 1, $almacen['Almacene']['id'], $this->request->data['Producto']['cantidad_cen']);
      $this->request->data['Ventascelulare']['user_id'] = $this->Session->read('Auth.User.id');
      $this->request->data['Ventascelulare']['producto_id'] = $idProducto;
      $this->request->data['Ventascelulare']['entrada'] = $this->request->data['Producto']['cantidad_cen'];
      $this->request->data['Ventascelulare']['almacene_id'] = $almacen['Almacene']['id'];
      $this->request->data['Ventascelulare']['sucursal_id'] = $almacen['Almacene']['sucursal_id'];
      $this->request->data['Ventascelulare']['transaccion'] = $this->get_num_trans_cel();
      $this->Ventascelulare->create();
      $this->Ventascelulare->save($this->request->data['Ventascelulare']);
    }
  }

  public function guarda_imagen() {
    $archivoImagen = $this->request->data['Producto']['imagen'];
    //$nombreOriginal = $this->request->data['Producto']['imagen']['name'];
    //debug($archivoImagen);exit;
    if ($archivoImagen['error'] === UPLOAD_ERR_OK) {
      $nombre = String::uuid();
      if (move_uploaded_file($archivoImagen['tmp_name'], WWW_ROOT . 'img_producto' . DS . $nombre . '.jpg')) {
        return 'img_producto' . DS . $nombre . '.jpg';
      } else {
        return NULL;
      }
    } else {
      return NULL;
    }
  }

  function ajaxproductos($n = Null) {

    $this->layout = 'ajax';
    $codu = $this->Session->read('tipo_id');
    $produsu = $this->Producto->find('list', array(
      'fields' => array('Producto.id', 'Producto.nombre'),
      'conditions' => array('Producto.tipousuario_id' => $codu),
      'recursive' => 0
    ));

    $this->set(compact('produsu', 'n', 'codu'));
    //debug($produsu);
  }

  function pedidos() {

    $codu = $this->Session->read('tipo_id');
    // $precios = $this->Preciosventa->find('all');exit;
    $produsu = $this->Producto->find('list', array(
      'fields' => array('Producto.id', 'Producto.nombre'),
      'conditions' => array('Producto.tipousuario_id' => $codu),
      'recursive' => 0
    ));

    //debug($produsu);
  }

  function editar($id = null) {
    $this->Producto->id = $id;
    if (!$id) {
      $this->Session->setFlash('No existe el producto');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if (empty($this->data)) {
      $this->data = $this->Producto->read(); //find(array('id' => $id));
    } else {
      //debug($this->request->data);exit;
      if (!empty($this->request->data['Producto']['imagen']['name'])) {
        $url_img = $this->guarda_imagen();
        if (!empty($url_img)) {
          $this->request->data['Producto']['url_imagen'] = $url_img;
        } else {
          $this->Session->setFlash('No se pudo registrar, problemas al cargar la imagen', 'msgerror');
          $this->redirect(array('action' => 'index'), null, true);
        }
      }
      if ($this->Producto->save($this->request->data['Producto'])) {
        $this->Session->setFlash('Producto Registrado', 'msgbueno');
      } else {
        $this->Session->setFlash('No se pudo registrar!!!', 'msgerror');
      }
      $this->redirect(array('action' => 'index'), null, true);
    }
    $marcas = $this->Marca->find('list', array('fields' => 'Marca.nombre'));
    $tiposproductos = $this->Producto->Tiposproducto->find('all', array('recursive' => -1));
    $colores = $this->Colore->find('list', array('fields' => 'Colore.nombre'));
    $this->set(compact('tiposproductos', 'marcas', 'colores'));
  }

  function buscar() {
    $data = $this->data['dato'];
    $options = array('OR' => array('Producto.ap_paterno LIKE' => '%' . $data .
        '%', 'Administrativo.ap_materno LIKE' => '%' . $data . '%',
        'Administrativo.nombre LIKE' => '%' . $data . '%', 'Administrativo.ci LIKE' =>
        '%' . $data . '%'));
    $result = $this->Administrativo->find('all', array('conditions' => array($options)));
    $this->set('administrativos', $result);
  }

  function delete($id = Null) {
    if (!$id) {
      $this->Session->setFlash('Codigo invalido');
      $this->redirect(array('action' => 'index'), null, true);
    }
    if ($this->Producto->delete($id)) {
      $this->Totale->deleteAll(array(['Totale.producto_id' => $id]));
      $this->Session->setFlash('El producto  ' . $id . ' fue borrado', 'msgbueno');
      $this->redirect(array('action' => 'index'), null, true);
    }
  }

  //Elimina los totales de  los productos no existentes
  public function regulariza_eli() {
    $totales = $this->Totale->find('all', ['recursive' => 0, 'fields' => ['Producto.id', 'Totale.id']]);
    foreach ($totales as $to) {
      if (empty($to['Producto']['id'])) {
        $this->Totale->delete($to['Totale']['id']);
      }
    }
    debug("Termino de regularizar");
    exit;
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

  public function registra_excel_pro() {
    /* debug($this->request->data);
      die; */
    $archivoExcel = $this->request->data['Excel']['excel'];
    $nombreOriginal = $this->request->data['Excel']['excel']['name'];

    if ($archivoExcel['error'] === UPLOAD_ERR_OK) {
      $nombre = String::uuid();
      if (move_uploaded_file($archivoExcel['tmp_name'], WWW_ROOT . 'files' . DS . $nombre . '.xlsx')) {
        $nombreExcel = $nombre . '.xlsx';
        $direccionExcel = WWW_ROOT . 'files';
        $this->request->data['Excelg']['nombre'] = $nombreExcel;
        $this->request->data['Excelg']['nombre_original'] = $nombreOriginal;
        $this->request->data['Excelg']['direccion'] = "";
        $this->request->data['Excelg']['tipo'] = "PRODUCTO";
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
        if ($row->getRowIndex() >= 2) { //a partir de la 1
          $rowIndex = $row->getRowIndex();
          $array_data[$rowIndex] = array(
            'A' => '',
            'B' => '',
            'C' => '',
            'D' => '',
            'E' => '',
            'F' => '',
            'G' => '',
            'H' => '');
          foreach ($cellIterator as $cell) {
            if ('A' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('B' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('C' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('D' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
              if ($array_data[$rowIndex][$cell->getColumn()] == '' || $array_data[$rowIndex][$cell->getColumn()] == NULL) {

                $this->redirect($this->referer());
              }
            } elseif ('E' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('F' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('G' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('H' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            }
          }
        }
      }
      $i = 0;

      $this->request->data = "";
      $duplicados = '';
      foreach ($array_data as $key => $d) {
        // ------ tipos producto -------
        $tipo_prod = $this->Tiposproducto->find('first', array(
          'conditions' => array('Tiposproducto.nombre LIKE' => $d['B'])
        ));
        if (!empty($tipo_prod)) {
          $idTip_prod = $tipo_prod['Tiposproducto']['id'];
          $nombre_tip_prod = $tipo_prod['Tiposproducto']['nombre'];
        } else {
          $this->Tiposproducto->create();
          $dtip_p['nombre'] = $d['B'];
          $this->Tiposproducto->save($dtip_p);
          $idTip_prod = $this->Tiposproducto->getLastInsertID();
          $nombre_tip_prod = $d['B'];
        }
        //------- termina tipos producto -----
        // ------ Marca -------
        $marca = $this->Marca->find('first', array(
          'recursive' => -1,
          'conditions' => array('Marca.nombre LIKE' => $d['C'])
        ));
        if (!empty($marca)) {
          $idMarca = $marca['Marca']['id'];
        } else {
          $this->Marca->create();
          $dmarca['nombre'] = $d['C'];
          $this->Marca->save($dmarca);
          $idMarca = $this->Marca->getLastInsertID();
        }

        // ------------- Valida duplicado --------------//
        $veri_prod = $this->Producto->find('first', array(
          'recursive' => -1,
          'conditions' => array('nombre' => $d['D'], 'marca_id' => $idMarca, 'tiposproducto_id' => $idTip_prod),
          'fields' => array('id')
        ));
        if (empty($veri_prod)) {
          $this->request->data['Producto']['tiposproducto_id'] = $idTip_prod;
          $this->request->data['Producto']['tipo_producto'] = $nombre_tip_prod;
          $this->request->data['Producto']['marca_id'] = $idMarca;
          $this->request->data['Producto']['nombre'] = $d['D'];
          $this->request->data['Producto']['observaciones'] = $d['E'];
          $this->request->data['Producto']['proveedor'] = 'VIVA';
          $this->request->data['Producto']['precio_compra'] = 0.00;
          $this->request->data['Producto']['fecha_ingreso'] = date("Y-m-d");
          $this->Producto->create();
          $this->Producto->save($this->request->data['Producto']);
          $idProducto = $this->Producto->getLastInsertID();

          $this->request->data['Productosprecio']['producto_id'] = $idProducto;
          $this->request->data['Productosprecio']['fecha'] = date('Y-m-d');
          if (!empty($d['F'])) {
            $this->request->data['Productosprecio']['precio'] = $d['F'];
            $this->request->data['Productosprecio']['tipousuario_id'] = 3;
            $this->request->data['Productosprecio']['escala_id'] = 1;
            $this->request->data['Productosprecio']['escala'] = 'MAYOR';
            $this->Productosprecio->create();
            $this->Productosprecio->save($this->request->data['Productosprecio']);
          }
          if (!empty($d['G'])) {
            $this->request->data['Productosprecio']['precio'] = $d['G'];
            $this->request->data['Productosprecio']['tipousuario_id'] = 2;
            $this->request->data['Productosprecio']['escala_id'] = 3;
            $this->request->data['Productosprecio']['escala'] = 'TIENDA';
            $this->Productosprecio->create();
            $this->Productosprecio->save($this->request->data['Productosprecio']);
          }
          if (!empty($d['H'])) {
            $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.central' => 1), 'fields' => array('Almacene.id', 'Almacene.sucursal_id')));
            $this->set_total($idProducto, 1, $almacen['Almacene']['id'], $d['H']);
            $this->request->data['Movimiento']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Movimiento']['producto_id'] = $idProducto;
            $this->request->data['Movimiento']['ingreso'] = $d['H'];
            $this->request->data['Movimiento']['almacene_id'] = $almacen['Almacene']['id'];
            $this->request->data['Movimiento']['sucursal_id'] = $almacen['Almacene']['sucursal_id'];
            $this->request->data['Movimiento']['transaccion'] = $this->get_num_trans();
            $this->Movimiento->create();
            $this->Movimiento->save($this->request->data['Movimiento']);
          }
        } else {
          if (empty($duplicados)) {
            $duplicados = $d['D'];
          } else {
            $duplicados = $duplicados . ', ' . $d['D'];
          }
        }
        //-------------- Termina valida -------------//
        //------- termina Marca -----
      }
      if (empty($duplicados)) {
        $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
      } else {
        $this->Session->setFlash("Estos productos no fueron registrados por ser duplicados: $duplicados", 'msginfo');
      }

      $this->redirect($this->referer());

      //fin funciones del excel
    } else {
      $this->redirect($this->referer());
      //echo 'no';
    }
  }

  public function registra_excel_cel() {
    /* debug($this->request->data);
      die; */
    $archivoExcel = $this->request->data['Excel']['excel'];
    $nombreOriginal = $this->request->data['Excel']['excel']['name'];

    if ($archivoExcel['error'] === UPLOAD_ERR_OK) {
      $nombre = String::uuid();
      if (move_uploaded_file($archivoExcel['tmp_name'], WWW_ROOT . 'files' . DS . $nombre . '.xlsx')) {
        $nombreExcel = $nombre . '.xlsx';
        $direccionExcel = WWW_ROOT . 'files';
        $this->request->data['Excelg']['nombre'] = $nombreExcel;
        $this->request->data['Excelg']['nombre_original'] = $nombreOriginal;
        $this->request->data['Excelg']['direccion'] = "";
        $this->request->data['Excelg']['tipo'] = "CELULAR";
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
        if ($row->getRowIndex() >= 2) { //a partir de la 1
          $rowIndex = $row->getRowIndex();
          $array_data[$rowIndex] = array(
            'A' => '',
            'B' => '',
            'C' => '',
            'D' => '',
            'E' => '',
            'F' => '');
          foreach ($cellIterator as $cell) {
            if ('A' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('B' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('C' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('D' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('E' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            } elseif ('F' == $cell->getColumn()) {
              $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
            }
          }
        }
      }
      $i = 0;
      /* debug($array_data);
        exit; */
      $this->request->data = "";
      $duplicados = '';
      foreach ($array_data as $d) {
        if ($d['A'] == '' || $d['B'] == '' || $d['C'] == '' || $d['D'] == '' || $d['E'] == '' || $d['F'] == '') {
          break;
        }
        // ------ Marca -------
        $marca = $this->Marca->find('first', array(
          'recursive' => -1,
          'conditions' => array('Marca.nombre LIKE' => $d['C'])
        ));
        if (!empty($marca)) {
          $idMarca = $marca['Marca']['id'];
        } else {
          $this->Marca->create();
          $dmarca['nombre'] = $d['C'];
          $this->Marca->save($dmarca);
          $idMarca = $this->Marca->getLastInsertID();
        }
        //------- termina Marca -----
        // ------ Color -------
        $color = $this->Colore->find('first', array(
          'recursive' => -1,
          'conditions' => array('Colore.nombre LIKE' => $d['D'])
        ));
        if (!empty($color)) {
          $idColor = $color['Colore']['id'];
        } else {
          $this->Colore->create();
          $dcolor['nombre'] = $d['D'];
          $this->Colore->save($dcolor);
          $idColor = $this->Colore->getLastInsertID();
        }
        //------- termina Color -----
        $veri_prod = $this->Producto->find('first', array(
          'recursive' => -1,
          'conditions' => array('nombre' => $d['A'], 'marca_id' => $idMarca, 'colore_id' => $idColor),
          'fields' => array('id')
        ));
        if (empty($veri_prod)) {

          $this->request->data['Producto']['tiposproducto_id'] = 5;
          $this->request->data['Producto']['tipo_producto'] = 'CELULARES';
          $this->request->data['Producto']['marca_id'] = $idMarca;
          $this->request->data['Producto']['colore_id'] = $idColor;
          $this->request->data['Producto']['nombre'] = $d['A'];
          $this->request->data['Producto']['proveedor'] = 'VIVA';
          $this->request->data['Producto']['precio_compra'] = $d['B'];
          $this->request->data['Producto']['fecha_ingreso'] = date("Y-m-d");
          $this->Producto->create();
          $this->Producto->save($this->request->data['Producto']);
          $idProducto = $this->Producto->getLastInsertID();

          if (!empty($d['E'])) {
            $this->request->data['Productosprecio']['producto_id'] = $idProducto;
            $this->request->data['Productosprecio']['escala_id'] = 3;
            $this->request->data['Productosprecio']['escala'] = 'TIENDA';
            $this->request->data['Productosprecio']['tipousuario_id'] = 2;
            $this->request->data['Productosprecio']['precio'] = $d['E'];
            $this->request->data['Productosprecio']['fecha'] = date('Y-m-d');
            $this->Productosprecio->create();
            $this->Productosprecio->save($this->request->data['Productosprecio']);
          }
          if (!empty($d['F'])) {
            $almacen = $this->Almacene->find('first', array('conditions' => array('Almacene.central' => 1), 'fields' => array('Almacene.id', 'Almacene.sucursal_id')));
            $this->set_total($idProducto, 1, $almacen['Almacene']['id'], $d['F']);
            $this->request->data['Ventascelulare']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Ventascelulare']['producto_id'] = $idProducto;
            $this->request->data['Ventascelulare']['entrada'] = $d['F'];
            //$this->request->data['Ventascelulare']['total'] = $total;
            $this->request->data['Ventascelulare']['almacene_id'] = $almacen['Almacene']['id'];
            $this->request->data['Ventascelulare']['sucursal_id'] = $almacen['Almacene']['sucursal_id'];
            $this->request->data['Ventascelulare']['transaccion'] = $this->get_num_trans_cel();
            $this->Ventascelulare->create();
            $this->Ventascelulare->save($this->request->data['Ventascelulare']);
          }
        } else {
          if (empty($duplicados)) {
            $duplicados = $d['A'];
          } else {
            $duplicados = $duplicados . ', ' . $d['A'];
          }
        }
      }
      if (empty($duplicados)) {
        $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
      } else {
        $this->Session->setFlash("Estos productos no fueron registrados por ser duplicados: $duplicados", 'msginfo');
      }
      $this->redirect($this->referer());

      //fin funciones del excel
    } else {
      $this->redirect($this->referer());
      //echo 'no';
    }
  }

  public function ajax_ing_alm_p($idProducto = null) {
    $this->layout = 'ajax';
    $producto = $this->Producto->findByid($idProducto, null, null, -1);
    $idAlmacenCentral = $this->get_id_alm_cent();
    if (!empty($this->request->data)) {

      if ($producto['Producto']['tipo_producto'] == 'CELULARES') {
        $this->request->data['Ventascelulare']['producto_id'] = $idProducto;
        $idAlmacen = $this->request->data['Ventascelulare']['almacene_id'] = $idAlmacenCentral;
        $almacen = $this->Almacene->findByid($idAlmacen, null, null, -1);
        $this->request->data['Ventascelulare']['sucursal_id'] = $almacen['Almacene']['sucursal_id'];
        $this->request->data['Ventascelulare']['entrada'] = $this->request->data['Producto']['ingreso'];
        $this->request->data['Ventascelulare']['user_id'] = $this->Session->read('Auth.User.id');
        $total = $this->get_total($idProducto, 1, $idAlmacen) + $this->request->data['Ventascelulare']['entrada'];
        $num_transaccion = $this->get_num_trans_cel();
        $this->request->data['Ventascelulare']['transaccion'] = $num_transaccion;
        $this->Ventascelulare->create();
        $this->Ventascelulare->save($this->request->data['Ventascelulare']);
        $this->set_total($idProducto, 1, $idAlmacen, $total);
        $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
      } else {
        $totalProducto = $this->get_total($idProducto, 1, $idAlmacenCentral);
        $num_transaccion = $this->get_num_trans();
        $datos = array();
        $datos['producto_id'] = $idProducto;
        $datos['user_id'] = $this->Session->read('Auth.User.id');
        $datos['almacene_id'] = $idAlmacenCentral;
        $datos['ingreso'] = $this->request->data['Producto']['ingreso'];
        $datos['salida'] = 0;
        $datos['transaccion'] = $num_transaccion;
        $this->Movimiento->create();
        $this->Movimiento->save($datos);
        $this->set_total($idProducto, 1, $idAlmacenCentral, ($totalProducto + $this->request->data['Producto']['ingreso']));
        $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
      }
      $this->redirect($this->referer());
    }
    $totalProducto = $this->get_total($idProducto, 1, $idAlmacenCentral);
    $this->set(compact('producto', 'totalProducto'));
  }

  public function ajax_ing_alm($idProducto = null) {
    $this->layout = 'ajax';
    $producto = $this->Producto->findByid($idProducto, null, null, -1);
    $idAlmacenCentral = $this->get_id_alm_cent();
    if (!empty($this->request->data)) {
      if ($producto['Producto']['tipo_producto'] == 'CELULARES') {
        $almacenCentral = $this->Almacene->findByid($idAlmacenCentral, null, null, -1);
        $almacen = $this->Almacene->findByid($this->request->data['Producto']['almacene_id'], null, null, -1);
        $num_transaccion = $this->get_num_trans_cel();
        $total_ultimo_c = $this->get_total($idProducto, 1, $idAlmacenCentral);
        $this->request->data['Ventascelulare']['producto_id'] = $idProducto;
        $this->request->data['Ventascelulare']['user_id'] = $this->Session->read('Auth.User.id');
        $this->request->data['Ventascelulare']['entrada'] = $this->request->data['Producto']['ingreso'];
        $this->request->data['Ventascelulare']['sucursal_id'] = $almacen['Almacene']['sucursal_id'];
        $this->request->data['Ventascelulare']['almacene_id'] = $this->request->data['Producto']['almacene_id'];
        if ($total_ultimo_c >= $this->request->data['Ventascelulare']['entrada']) {
          $total = $this->get_total($idProducto, 1, $this->request->data['Producto']['almacene_id']) + $this->request->data['Ventascelulare']['entrada'];
          $this->request->data['Ventascelulare']['transaccion'] = $num_transaccion;
          $this->Ventascelulare->create();
          $this->Ventascelulare->save($this->request->data['Ventascelulare']);
          $this->set_total($idProducto, 1, $this->request->data['Producto']['almacene_id'], $total);
          $this->request->data['Ventascelulare']['salida'] = $this->request->data['Ventascelulare']['entrada'];
          //$this->request->data['Ventascelulare']['total'] = $total_ultimo_c - $this->request->data['Ventascelulare']['salida'];
          $this->request->data['Ventascelulare']['almacene_id'] = $idAlmacenCentral;
          $this->request->data['Ventascelulare']['sucursal_id'] = $almacenCentral['Almacene']['sucursal_id'];
          $this->request->data['Ventascelulare']['transaccion'] = $num_transaccion;
          $this->request->data['Ventascelulare']['entrada'] = 0;
          $this->Ventascelulare->create();
          $this->Ventascelulare->save($this->request->data['Ventascelulare']);
          $this->set_total($idProducto, 1, $idAlmacenCentral, ($total_ultimo_c - $this->request->data['Ventascelulare']['salida']));
          $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
        } else {
          $this->Session->setFlash('No hay sudiciente en almacen central!!', 'msgerror');
        }
      } else {
        $totalProducto = $this->get_total($idProducto, 1, $idAlmacenCentral);
        $num_transaccion = $this->get_num_trans();
        if ($totalProducto >= $this->request->data['Producto']['ingreso']) {
          $datos = array();
          $datos['producto_id'] = $idProducto;
          $datos['user_id'] = $this->Session->read('Auth.User.id');
          $datos['almacene_id'] = $this->request->data['Producto']['almacene_id'];
          $datos['ingreso'] = $this->request->data['Producto']['ingreso'];
          $datos['salida'] = 0;
          $datos['transaccion'] = $num_transaccion;
          $this->Movimiento->create();
          $this->Movimiento->save($datos);
          $this->set_total($idProducto, 1, $this->request->data['Producto']['almacene_id'], ($this->get_total($idProducto, 1, $this->request->data['Producto']['almacene_id']) + $this->request->data['Producto']['ingreso']));

          $datos = array();
          $datos['producto_id'] = $idProducto;
          $datos['user_id'] = $this->Session->read('Auth.User.id');
          $datos['almacene_id'] = $idAlmacenCentral;
          $datos['ingreso'] = 0;
          $datos['salida'] = $this->request->data['Producto']['ingreso'];
          $datos['transaccion'] = $num_transaccion;
          $this->Movimiento->create();
          $this->Movimiento->save($datos);
          $this->set_total($idProducto, 1, $idAlmacenCentral, ($totalProducto - $this->request->data['Producto']['ingreso']));
          $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
        } else {
          $this->Session->setFlash("No se pudo registrar en almacen hay " . $totalProducto, 'msgerror');
        }
      }
      $this->redirect($this->referer());
    }
    $totalProductoC = $this->get_total($idProducto, 1, $idAlmacenCentral);
    $sql = "SELECT totales.total FROM totales WHERE totales.producto_id = $idProducto AND totales.almacene_id = Almacene.id LIMIT 1";
    $this->Almacene->virtualFields = array(
      'nombre_comp' => "CONCAT(Almacene.nombre,' (',(SELECT IF(EXISTS($sql),($sql),0)),')')"
    );
    $almacenes = $this->Almacene->find('list', array(
      'fields' => array('Almacene.id', 'Almacene.nombre_comp'),
      'conditions' => array('Almacene.central !=' => 1)
    ));
    //debug($almacenes);exit;
    $this->set(compact('producto', 'almacenes', 'totalProductoC'));
  }

  public function get_id_alm_cent() {
    $almacen = $this->Almacene->find('first', array('recursive' => -1, 'conditions' => array('Almacene.central' => 1), 'fields' => array('Almacene.id')));
    if (!empty($almacen)) {
      return $almacen['Almacene']['id'];
    } else {
      return 0;
    }
  }

}

?>
