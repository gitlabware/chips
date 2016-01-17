<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));
App::uses('AppController', 'Controller');

class ImpulsadoresController extends AppController {

  var $uses = array('User', 'Minievento', 'Movimiento', 'Ventasimpulsadore', 'Producto', 'Premio', 'Movimientospremio', 'Precio', 'Totale', 'Chip', 'Productosprecio');
  public $layout = 'viva';

  public function minievento($idMini = null) {
    $this->layout = 'ajax';
    $this->Minievento->id = $idMini;
    $this->request->data = $this->Minievento->read();
  }

  public function minieventos() {
    $minieventos = $this->Minievento->find('all', array(
      'recursive' => -1,
      'order' => array('Minievento.fecha DESC')
    ));
    $this->set(compact('minieventos'));
  }

  public function lista_minieventos() {
    $minieventos = $this->Minievento->find('all', array(
      'recursive' => -1,
      'order' => array('Minievento.fecha DESC'),
      'conditions' => array('Minievento.estado' => 1)
    ));
    $this->set(compact('minieventos'));
  }

  public function registra_minievento() {
    if (!empty($this->request->data['Minievento'])) {
      $this->Minievento->create();
      $this->Minievento->save($this->request->data['Minievento']);
      $this->Session->setFlash("Se registro correctamente el minievento", 'msgbueno');
    } else {
      $this->Session->setFlash("No se pudo registrar el minievento", 'msgerror');
    }
    $this->redirect(array('action' => 'minieventos'));
  }

  public function ventas_minievento($idMiniEvento = null) {
    $minievento = $this->Minievento->findByid($idMiniEvento, null, null, -1);
    $idPersona = $this->Session->read('Auth.User.persona_id');
    //debug($idPersona);exit;

    $sql1 = "(SELECT SUM(movimientos.salida) FROM movimientos WHERE movimientos.minievento_id = $idMiniEvento AND movimientos.persona_id = $idPersona AND movimientos.salida != 0 AND  !ISNULL(movimientos.salida) AND movimientos.producto_id = Totale.producto_id)";
    $sql2 = "(SELECT SUM(movimientos.salida*movimientos.precio_uni) FROM movimientos WHERE movimientos.minievento_id = $idMiniEvento AND movimientos.persona_id = $idPersona AND movimientos.salida != 0 AND  !ISNULL(movimientos.salida) AND movimientos.producto_id = Totale.producto_id)";
    $this->Totale->virtualFields = array(
      'vendidos' => "IF(ISNULL($sql1),0,$sql1)",
      'precio_vendidos' => "IF(ISNULL($sql2),0,$sql2)"
    );
    $productos = $this->Totale->find('all', array(
      'recursive' => 0,
      'conditions' => array('Totale.persona_id' => $idPersona, 'Totale.total !=' => 0, ''),
      'fields' => array('Totale.*', 'Producto.nombre', 'Producto.tipo_producto', 'Producto.id')
    ));
    $idUser = $this->Session->read('Auth.User.id');
    //debug($idUser);exit;
    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array('Chip.distribuidor_id' => $idUser, 'Chip.estado !=' => 'Vendido'),
    ));
    //debug($chips);exit;

    $ventas_i = $this->Ventasimpulsadore->find('all', array(
      'recursive' => 0,
      'conditions' => array('Ventasimpulsadore.minievento_id' => $idMiniEvento, 'Ventasimpulsadore.user_id' => $idUser),
      'fields' => array('Ventasimpulsadore.*', 'Producto.nombre')
    ));



    $this->set(compact('minievento', 'productos', 'chips', 'idMiniEvento', 'ventas_i'));
  }

  public function ventas_minievento2($idMiniEvento = null, $idUser = null) {
    $minievento = $this->Minievento->findByid($idMiniEvento, null, null, -1);
    $ususario = $this->User->find('first', array(
      'recursive' => 0,
      'conditions' => array('User.id' => $idUser),
      'fields' => array('Persona.*')
    ));
    $idPersona = $ususario['Persona']['id'];
    //debug($idPersona);exit;

    $sql1 = "(SELECT SUM(movimientos.salida) FROM movimientos WHERE movimientos.minievento_id = $idMiniEvento AND movimientos.persona_id = $idPersona AND movimientos.salida != 0 AND  !ISNULL(movimientos.salida) AND movimientos.producto_id = Totale.producto_id)";
    $sql2 = "(SELECT SUM(movimientos.salida*movimientos.precio_uni) FROM movimientos WHERE movimientos.minievento_id = $idMiniEvento AND movimientos.persona_id = $idPersona AND movimientos.salida != 0 AND  !ISNULL(movimientos.salida) AND movimientos.producto_id = Totale.producto_id)";
    $this->Totale->virtualFields = array(
      'vendidos' => "IF(ISNULL($sql1),0,$sql1)",
      'precio_vendidos' => "IF(ISNULL($sql2),0,$sql2)"
    );
    $productos = $this->Totale->find('all', array(
      'recursive' => 0,
      'conditions' => array('Totale.persona_id' => $idPersona, 'Totale.total !=' => 0, ''),
      'fields' => array('Totale.*', 'Producto.nombre', 'Producto.tipo_producto', 'Producto.id')
    ));
    //$idUser = $this->Session->read('Auth.User.id');
    //debug($idUser);exit;
    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array('Chip.distribuidor_id' => $idUser, 'Chip.estado !=' => 'Vendido'),
    ));
    //debug($chips);exit;

    $ventas_i = $this->Ventasimpulsadore->find('all', array(
      'recursive' => 0,
      'conditions' => array('Ventasimpulsadore.minievento_id' => $idMiniEvento, 'Ventasimpulsadore.user_id' => $idUser),
      'fields' => array('Ventasimpulsadore.*', 'Producto.nombre')
    ));



    $this->set(compact('minievento', 'productos', 'chips', 'idMiniEvento', 'ventas_i', 'ususario', 'idUser'));
  }

  public function registra_venta() {

    if (!empty($this->request->data['Ventasimpulsadore']['premio_id'])) {
      $premio = $this->Premio->findByid($this->request->data['Ventasimpulsadore']['premio_id'], null, null, -1);
      if ($premio['Premio']['total'] >= 1) {
        $this->Premio->id = $premio['Premio']['id'];
        $dpre['total'] = $premio['Premio']['total'] - 1;
        $this->Premio->save($dpre);
        $this->Movimientospremio->create();
        $dmov['premio_id'] = $premio['Premio']['id'];
        $dmov['user_id'] = $this->Session->read('Auth.User.id');
        $dmov['salida'] = 1;
        $dmov['persona_id'] = $this->Session->read('Auth.User.persona_id');
        $this->Movimientospremio->save($dmov);
      } else {
        $this->Session->setFlash("No se pudo registrar no hay premio!!", 'msgerror');
        $this->redirect($this->referer());
      }
    }
    $this->request->data['Ventasimpulsadore']['persona_id'] = $this->Session->read('Auth.User.persona_id');
    $this->Ventasimpulsadore->create();
    $this->Ventasimpulsadore->save($this->request->data['Ventasimpulsadore']);
    $this->Session->setFlash("Se registro correctamente la venta!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function quita_venta($idVenta = null) {
    $venta = $this->Ventasimpulsadore->findByid($idVenta, null, null, -1);
    if (!empty($venta['Ventasimpulsadore']['premio_id'])) {
      $premio = $this->Premio->findByid($venta['Ventasimpulsadore']['premio_id']);
      $this->Premio->id = $premio['Premio']['id'];
      $dpre['total'] = $premio['Premio']['total'] + 1;
      $this->Premio->save($dpre);
      $this->Movimientospremio->create();
      $dmov['premio_id'] = $premio['Premio']['id'];
      $dmov['user_id'] = $this->Session->read('Auth.User.id');
      $dmov['persona_id'] = $this->Session->read('Auth.User.persona_id');
      $dmov['ingreso'] = 1;
      $this->Movimientospremio->save($dmov);
    }
    $this->Ventasimpulsadore->delete($idVenta);
    $this->Session->setFlash("Se elimino correctamente la venta!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function elimina_minievento($idMiniEvento = null) {
    $this->Minievento->delete($idMiniEvento);
    $this->Session->setFlash("Se ha eliminado correctamente!!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function premios() {
    $premios = $this->Premio->find('all');
    $this->set(compact('premios'));
  }

  public function registra_n_premio() {
    $this->Premio->create();
    $this->Premio->save($this->request->data['Premio']);
    $idPremio = $this->Premio->getLastInsertID();
    $this->Movimientospremio->create();
    $datm['premio_id'] = $idPremio;
    $datm['ingreso'] = $this->request->data['Premio']['total'];
    $datm['user_id'] = $this->Session->read('Auth.User.id');
    $this->Movimientospremio->save($datm);
    $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
    $this->redirect(array('action' => 'premios'));
  }

  public function movimientospremios($idPremio = null) {
    $premio = $this->Premio->findByid($idPremio);
    $movimientos = $this->Movimientospremio->find('all', array(
      'recursive' => 0,
      'conditions' => array('Movimientospremio.premio_id' => $idPremio, 'Movimientospremio.user_id' => $this->Session->read('Auth.User.id')),
      'fields' => array('Movimientospremio.created', 'Movimientospremio.ingreso', 'Movimientospremio.id'),
      'order' => array('Movimientospremio.id DESC')
    ));
    $this->set(compact('premio', 'movimientos'));
  }

  public function registra_entrega_pre() {
    $this->Movimientospremio->create();
    $this->Movimientospremio->save($this->request->data['Movimientospremio']);
    $premio = $this->Premio->findByid($this->request->data['Movimientospremio']['premio_id']);
    $this->Premio->id = $premio['Premio']['id'];
    $datp['total'] = $premio['Premio']['total'] + $this->request->data['Movimientospremio']['ingreso'];
    $this->Premio->save($datp);
    $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function cancela_ent_pre($idMov = null) {
    $movimiento = $this->Movimientospremio->findByid($idMov, null, null, -1);
    $premio = $this->Premio->findByid($movimiento['Movimientospremio']['premio_id'], null, null, -1);
    if ($premio['Premio']['total'] >= $movimiento['Movimientospremio']['ingreso']) {
      $this->Premio->id = $premio['Premio']['id'];
      $dmov['total'] = $premio['Premio']['total'] - $movimiento['Movimientospremio']['ingreso'];
      $this->Premio->save($dmov);
      $this->Movimientospremio->delete($idMov);
      $this->Session->setFlash("Se cancelo correctamente la entrega!!", 'msgbueno');
    } else {
      $this->Session->setFlash("No se pudo tegistrar debido a que el total es inferior al monto!!", 'msgerror');
    }
    $this->redirect($this->referer());
  }

  public function genera_excel($idMinievento = NULL) {
    $minievento = $this->Minievento->findByid($idMinievento, NULL, NULL, -1);
    $nombre_excel = $minievento['Minievento']['direccion'] . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');
    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 13, 1);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 2, 13, 2);
    $style1 = array('alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ), 'font' => array(
        'size' => 14,
        'bold' => true,
        'underline' => 'single'
    ));
    $style2 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'font' => array('size' => 8, 'bold' => true),
      'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
    );
    $prueba->getActiveSheet()->getStyle("A1:N1")->applyFromArray($style1);
    $prueba->getActiveSheet()->getStyle("A2:N2")->applyFromArray($style1);
    $prueba->getActiveSheet()->getStyle("A4:N4")->applyFromArray($style2);
    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "CONTROL DE VENTAS MINIEVENTOS");
    $prueba->setActiveSheetIndex(0)->setCellValue("A2", "TRADICIONAL EL ALTO");

    $prueba->setActiveSheetIndex(0)->setCellValue("A4", "N°");
    $prueba->setActiveSheetIndex(0)->setCellValue("B4", "FECHA");
    $prueba->setActiveSheetIndex(0)->setCellValue("C4", "LUGAR MINIEVENTO");
    $prueba->setActiveSheetIndex(0)->setCellValue("D4", "MEGADEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("E4", "TIPO DE\nMINIEVENTO");
    $prueba->setActiveSheetIndex(0)->setCellValue("F4", "IMPULSADOR\n/ BRIGADISTA");
    $prueba->setActiveSheetIndex(0)->setCellValue("G4", "CODIGO\nSUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("H4", "NOMBRE\nSUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("I4", "NUMERO\nPREPAGO");
    $prueba->setActiveSheetIndex(0)->setCellValue("J4", "NUMERO\n4G");
    $prueba->setActiveSheetIndex(0)->setCellValue("K4", "NOMBRE\nCLIENTE");
    $prueba->setActiveSheetIndex(0)->setCellValue("L4", "MONTO BS.");
    $prueba->setActiveSheetIndex(0)->setCellValue("M4", "PREMIO\nENTREGADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("N4", "N°\nREFERENCIA");

    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('N')->setWidth(11);

    $prueba->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setWrapText(true);

    $prueba->getActiveSheet()->setTitle("CONTROL DE VENTAS MINIEVENTOS");

    $ventas = $this->Ventasimpulsadore->find('list', array(
      'recursive' => 0,
      'conditions' => array('Ventasimpulsadore.minievento_id' => $idMinievento),
      'fields' => array('Minievento.fecha', 'Minievento.direccion', 'Persona.nombre', 'Persona.ap_paterno', 'Persona.ap_materno', 'Ventasimpulsadore.4g', 'Ventasimpulsadore.numero', 'Ventasimpulsadore.nombre_cliente', 'Ventasimpulsadore.monto', 'Premio.nombre', 'Ventasimpulsadore.tel_referencia')
    ));
    $indice = 4;
    $contador = 0;
    foreach ($ventas as $ve) {
      $indice++;
      $contador++;
      $prueba->getActiveSheet()->getStyle("A$indice:N$indice")->applyFromArray($style2);
      if ($ve['Ventasimpulsadore']['4g'] == 1) {
        $numero_prepago = "";
        $numero_4g = $ve['Ventasimpulsadore']['numero'];
      } else {
        $numero_prepago = $ve['Ventasimpulsadore']['numero'];
        $numero_4g = "";
      }

      $prueba->setActiveSheetIndex(0)->setCellValue("A$indice", $contador);
      $prueba->setActiveSheetIndex(0)->setCellValue("B$indice", $ve['Minievento']['fecha']);
      $prueba->setActiveSheetIndex(0)->setCellValue("C$indice", $ve['Minievento']['direccion']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D$indice", "");
      $prueba->setActiveSheetIndex(0)->setCellValue("E$indice", "");
      $prueba->setActiveSheetIndex(0)->setCellValue("F$indice", $ve['Persona']['nombre'] . " " . $ve['Persona']['ap_paterno'] . ' ' . $ve['Persona']['ap_materno']);
      $prueba->setActiveSheetIndex(0)->setCellValue("G$indice", "");
      $prueba->setActiveSheetIndex(0)->setCellValue("H$indice", "");
      $prueba->setActiveSheetIndex(0)->setCellValue("I$indice", $numero_prepago);
      $prueba->setActiveSheetIndex(0)->setCellValue("J$indice", $numero_4g);
      $prueba->setActiveSheetIndex(0)->setCellValue("K$indice", $ve['Ventasimpulsadore']['nombre_cliente']);
      $prueba->setActiveSheetIndex(0)->setCellValue("L$indice", $ve['Ventasimpulsadore']['monto']);
      $prueba->setActiveSheetIndex(0)->setCellValue("M$indice", $ve['Premio']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("N$indice", $ve['Ventasimpulsadore']['tel_referencia']);
    }

    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function ajax_venta_chips($idMiniEvento = null, $idChip = null, $idPersona = null) {
    $this->layout = 'ajax';
    if (!empty($this->request->data)) {
      /* debug($this->request->data);
        exit; */
      if (empty($idPersona)) {
        $idPersona = $this->Session->read('Auth.User.persona_id');
        $idUser = $this->Session->read('Auth.User.id');
      } else {
        $usuario = $this->User->find('first', array(
          'recursive' => 0,
          'conditions' => array('User.persona_id' => $idPersona),
          'fields' => array('User.*')
        ));
        $idUser = $usuario['User']['id'];
      }

      if (!empty($this->request->data['Ventasimpulsadore']['producto_id'])) {

        $producto = $this->Totale->find('first', array(
          'recursive' => 0,
          'conditions' => array('Totale.producto_id' => $this->request->data['Ventasimpulsadore']['producto_id'], 'Totale.persona_id' => $idPersona),
          'fields' => array('Producto.nombre', 'Totale.total', 'Totale.id')
        ));
        if ($producto['Totale']['total'] > 0) {


          $this->Chip->id = $this->request->data['Ventasimpulsadore']['chip_id'];
          $dchip['estado'] = 'Vendido';
          $this->Chip->save($dchip);
          $this->request->data['Ventasimpulsadore']['user_id'] = $idUser;
          $this->Ventasimpulsadore->create();
          $this->Ventasimpulsadore->save($this->request->data['Ventasimpulsadore']);


          $d_mov['user_id'] = $idUser;
          $d_mov['producto_id'] = $this->request->data['Ventasimpulsadore']['producto_id'];
          $d_mov['cliente_id'] = 0;
          $d_mov['nombre_prod'] = $producto['Producto']['nombre'];
          $d_mov['escala'] = 'MAYOR';
          $d_mov['precio_uni'] = $this->request->data['Ventasimpulsadore']['precio_producto'];
          $d_mov['persona_id'] = $idPersona;
          $d_mov['minievento_id'] = $idMiniEvento;
          $d_mov['ventasimpulsadore_id'] = $this->Ventasimpulsadore->getLastInsertID();
          $d_mov['salida'] = 1;
          $this->Movimiento->create();
          $this->Movimiento->save($d_mov);
          $this->Totale->id = $producto['Totale']['id'];
          $d_total['total'] = $producto['Totale']['total'] - 1;
          $this->Totale->save($d_total);

          $this->Session->setFlash("Se ha registrado correctamente la venta!!", 'msgbueno');
          $this->redirect($this->referer());
        } else {
          $this->Session->setFlash("No se ha podido registrar la venta debido a que no tiene para descontar!!", 'msgerror');
          $this->redirect($this->referer());
        }
      } else {
        $this->Chip->id = $this->request->data['Ventasimpulsadore']['chip_id'];
        $dchip['estado'] = 'Vendido';
        $this->Chip->save($dchip);
        $this->request->data['Ventasimpulsadore']['user_id'] = $idUser;
        $this->Ventasimpulsadore->create();
        $this->Ventasimpulsadore->save($this->request->data['Ventasimpulsadore']);
        $this->Session->setFlash("Se ha registrado correctamente la venta!!", 'msgbueno');
        $this->redirect($this->referer());
      }
    }


    $precios_chip = $this->Precio->find('list', array(
      'fields' => array('Precio.monto', 'Precio.monto'),
      'conditions' => array('Precio.descripcion' => 'Chips')
    ));
    $chip = $this->Chip->find('first', array(
      'recursive' => -1,
      'conditions' => array('Chip.id' => $idChip)
    ));
    if (empty($idPersona)) {
      $idPersona = $this->Session->read('Auth.User.persona_id');
    }
    $sql = "(SELECT productos.nombre,productos.id,pro.precio, tot.total FROM productosprecios pro,totales tot LEFT JOIN productos ON (productos.id = tot.producto_id) WHERE tot.persona_id = $idPersona AND tot.total != 0 AND productos.tipo_producto = 'PREMIOS' AND tot.producto_id = pro.producto_id AND pro.tipousuario_id = 4)";
    $premios = $this->Productosprecio->query($sql);
    /* debug($premios);
      exit; */
    $this->set(compact('precios_chip', 'chip', 'premios', 'idMiniEvento'));
  }

  public function ajax_venta($idMiniEvento = null, $idProducto = null, $persona = null) {
    if (empty($persona)) {
      $persona = $this->Session->read('Auth.User.persona_id');
      $idUser = $this->Session->read('Auth.User.id');
    } else {
      $usuario = $this->User->find('first', array(
        'recursive' => 0,
        'conditions' => array('User.persona_id' => $persona),
        'fields' => array('User.*')
      ));
      $idUser = $usuario['User']['id'];
    }

    $this->layout = 'ajax';
    //debug($idProducto);exit;
    $fecha = date('Y-m-d');
    //$this->request->data['Movimiento']['created'] = date('Y-m-d');
    $precios = $this->Productosprecio->find('all', array(
      'recursive' => -1,
      'conditions' => array('Productosprecio.producto_id' => $idProducto, 'Productosprecio.tipousuario_id' => 4),
      'fields' => array('Productosprecio.precio')
    ));
    $producto = $this->Producto->find('first', array(
      'recursive' => -1,
      'conditions' => array('Producto.id' => $idProducto),
      'fields' => array('Producto.nombre')
    ));
    $movimientos = $this->Movimiento->find('all', array(
      'recursive' => -1,
      'conditions' => array('Movimiento.minievento_id' => $idMiniEvento, 'Movimiento.persona_id' => $persona, 'Movimiento.salida !=' => 0, 'Movimiento.salida !=' => NULL, 'Movimiento.producto_id' => $idProducto, 'Movimiento.ventasimpulsadore_id' => NULL),
      'fields' => array('Movimiento.id', 'Movimiento.modified', 'Movimiento.precio_uni', 'Movimiento.salida')
    ));
    $this->set(compact('producto', 'precios', 'idProducto', 'persona', 'fecha', 'movimientos', 'idMiniEvento', 'idUser'));
  }

  public function cancela_venta_chip($idVentaImp = null) {
    $venta = $this->Ventasimpulsadore->find('first', array(
      'recursive' => 0,
      'conditions' => array('Ventasimpulsadore.id' => $idVentaImp),
      'fields' => array('Ventasimpulsadore.*', 'User.persona_id')
    ));
    if (!empty($venta['Ventasimpulsadore']['producto_id'])) {
      $this->Movimiento->deleteAll(array('ventasimpulsadore_id' => $idVentaImp));
      $total = $this->Totale->find('first', array(
        'recursive' => -1,
        'conditions' => array('Totale.producto_id' => $venta['Ventasimpulsadore']['producto_id'], 'Totale.persona_id' => $venta['User']['persona_id'])
      ));
      $this->Totale->id = $total;
      $d_total['total'] = $total['Totale']['total'] + 1;
      $this->Totale->save($d_total);
    }
    $this->Chip->id = $venta['Ventasimpulsadore']['chip_id'];
    $d_chip['estado'] = '';
    $this->Chip->save($d_chip);
    $this->Ventasimpulsadore->delete($idVentaImp);
    $this->Session->setFlash("Se ha eliminado correctamente la venta", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function elimina_venta_dis($idMovimiento = null) {
    $movimiento = $this->Movimiento->find('first', array(
      'recursive' => 0,
      'conditions' => array('Movimiento.id' => $idMovimiento),
      'fields' => array('Movimiento.salida', 'Almacene.id', 'Almacene.central', 'Movimiento.producto_id', 'Movimiento.persona_id')
    ));
    //debug($movimiento);exit;
    $total = $this->Totale->find('first', array(
      'recursive' => -1,
      'conditions' => array('Totale.producto_id' => $movimiento['Movimiento']['producto_id'], 'Totale.persona_id' => $movimiento['Movimiento']['persona_id'])
    ));

    //$total_p = $this->get_total($movimiento['Movimiento']['producto_id'], 0, $movimiento['Movimiento']['persona_id']);
    //debug($total_p);exit;
    $this->Movimiento->delete($idMovimiento);
    //$this->set_total($movimiento['Movimiento']['producto_id'], 0, $movimiento['Movimiento']['persona_id'], ($total_p + $movimiento['Movimiento']['salida']));
    $this->Totale->id = $total['Totale']['id'];
    $d_total['total'] = $total['Totale']['total'] + $movimiento['Movimiento']['salida'];
    $this->Totale->save($d_total);
    $this->Session->setFlash("Se ha eliminado correctamente el movimiento!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function cambiopass() {
    $this->layout = 'ajax';
    $idUser = $this->Session->read('Auth.User.id');

    if (!empty($this->request->data['Dato']['password'])) {
      $this->User->id = $idUser;
      $this->request->data['User']['password'] = $this->request->data['Dato']['password'];
      $this->User->save($this->request->data['User']);
      $this->Session->setFlash("Se ha cambiado el password con exito!!", 'msgbueno');
      $this->redirect($this->referer());
    }
  }

}
