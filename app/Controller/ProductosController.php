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
    if ($this->RequestHandler->responseType() == 'json') {
      $sql = '(SELECT COUNT(id) FROM productosprecios WHERE (productosprecios.producto_id = Producto.id))';
      $editar = '<a href="javascript:" class="button orange-gradient compact icon-pencil" onclick="editar_p(' . "',Producto.id,'" . ')">Editar</a>';
      $precios = '<a href="javascript:" class="button anthracite-gradient compact icon-page-list" onclick="precios_productos(' . "',Producto.id,'" . ')">Precios</a>';
      $elimina = '<button class="button red-gradient compact icon-cross-round" type="button" onclick="elimina_p(' . "',Producto.id,'" . ')">Eliminar</button>';
      $acciones = "$editar $precios $elimina";
      $small_r = '<small class="tag red-bg" id="idproducto-' . "',Producto.id,'" . '"> ' . "',$sql,'" . ' </small></td>';
      $small_n = '<small class="tag " id="idproducto-' . "',Producto.id,'" . '"> ' . "',$sql,'" . ' </small></td>';
      $this->Producto->virtualFields = array(
        'imagen' => "CONCAT(IF(ISNULL(Producto.url_imagen),'',CONCAT('" . '<img src="' . "',Producto.url_imagen,'" . '" height="51" width="51">' . "')))",
        'precios' => "CONCAT((IF($sql = 0,CONCAT('$small_r'),CONCAT('$small_n'))))",
        'acciones' => "CONCAT('$acciones')"
      );
      $this->paginate = array(
        'fields' => array('Producto.precios', 'Producto.imagen', 'Producto.nombre', 'Producto.precio_compra', 'Producto.proveedor', 'Producto.fecha_ingreso', 'Producto.acciones'),
        'recursive' => -1,
        'order' => 'Producto.id DESC'
      );
      $this->DataTable->fields = array('Producto.precios', 'Producto.imagen', 'Producto.nombre', 'Producto.precio_compra', 'Producto.proveedor', 'Producto.fecha_ingreso', 'Producto.acciones');
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
      $this->request->data['Ventascelulare']['total'] = $total;
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
      $nombre = string::uuid();
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
      $this->Session->setFlash('El producto  ' . $id . ' fue borrado');
      $this->redirect(array('action' => 'index'), null, true);
    }
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
    /*debug($this->request->data);
    die;*/
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
      debug($array_data);exit;
      foreach ($array_data as $d) {
        $this->request->data[$i]['Producto']['cantidad'] = $d['B'];
        $this->request->data[$i]['Producto']['cantidad'] = $d['C'];
        $i++;
      }
      if (!empty($this->request->data[0]['Chip']['telefono'])) {
        $verifica_tel = $this->Chip->find('first', array('conditions' => array('Chip.telefono' => $this->request->data[0]['Chip']['telefono'])));
        if (!empty($verifica_tel)) {
          $this->Session->setFlash("Ya se registro el excel verifique!!", 'msgerror');
          $this->redirect(array('action' => 'subirexcel'));
        }
      }

      //debug($this->data);
      //exit;
      /*
      if ($this->Chip->saveMany($this->data)) {
        //echo 'registro corectamente';
        //$this->Chip->deleteAll(array('Chip.sim' => '')); //limpiamos el excel con basuras
        $this->Session->setFlash('se Guardo correctamente el EXCEL', 'msgbueno');
        $this->redirect(array('action' => 'subirexcel'));
      } else {
        echo 'no se pudo guardar';
      }*/
      //fin funciones del excel
    } else {

      //echo 'no';
    }
  }

}

?>
