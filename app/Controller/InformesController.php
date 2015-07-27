<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

class InformesController extends AppController {

  //public $helpers = array('Html', 'Form', 'Session', 'Js');
  public $uses = array('User', 'Movimiento', 'Cliente', 'Rutasusuario', 'Persona', 'Ventasdistribuidore', 'Ventasproducto', 'Ventascliente','Lugare');
  public $layout = 'viva';
  public $components = array('RequestHandler', 'DataTable');

  public function beforeFilter() {
    parent::beforeFilter();
    if ($this->RequestHandler->responseType() == 'json') {
      $this->RequestHandler->setContent('json', 'application/json');
    }
  }

  public function excel_lista_personal() {
    $nombre_excel = "Listado-personal.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');

    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 1, 3);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(2, 1, 10, 3);
    $prueba->setActiveSheetIndex(0)->setCellValue("C1", "LISTADO DE PERSONAL");
    $prueba->getActiveSheet()->setTitle("LISTADO de Personal");
    $style1 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 22, 'bold' => true));
    $prueba->getActiveSheet()->getStyle("C1:k1")->applyFromArray($style1);

    $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $style3 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $prueba->getActiveSheet()->getStyle('L1')->applyFromArray($style2);
    $prueba->getActiveSheet()->getStyle('L2')->applyFromArray($style2);
    $prueba->getActiveSheet()->getStyle('L3')->applyFromArray($style2);

    $prueba->getActiveSheet()->getStyle('M1')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('M2')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('M3')->applyFromArray($style3);

    $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(23);
    $prueba->getActiveSheet()->getRowDimension(2)->setRowHeight(23);
    $prueba->getActiveSheet()->getRowDimension(3)->setRowHeight(20);

    $prueba->setActiveSheetIndex(0)->setCellValue("L1", "Codigo: ");
    $prueba->setActiveSheetIndex(0)->setCellValue("L2", "Version: ");
    $prueba->setActiveSheetIndex(0)->setCellValue("L3", "Pagina: ");

    $prueba->setActiveSheetIndex(0)->setCellValue("M1", "FR - 2 ");
    $prueba->setActiveSheetIndex(0)->setCellValue("M2", "1");
    $prueba->setActiveSheetIndex(0)->setCellValue("M3", "1 de 1");

    $objImagen = new PHPExcel_Worksheet_Drawing();

    $objImagen->setPath(WWW_ROOT . 'img' . DS . 'logoviva.png');
    $objImagen->setCoordinates('A1');
    $objImagen->setWorksheet($prueba->getActiveSheet());
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(24);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(13);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(13);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(16);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(16);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(13);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(24);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(22);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(31);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(30);
    $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(40);

    $style4 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '006837')));
    $prueba->getActiveSheet()->getRowDimension(6)->setRowHeight(-1);
    $prueba->getActiveSheet()->getStyle('A6:M6')->applyFromArray($style4);
    $prueba->setActiveSheetIndex(0)->setCellValue("A6", "No");
    $prueba->setActiveSheetIndex(0)->setCellValue("B6", "NOMBRE(S)");
    $prueba->setActiveSheetIndex(0)->setCellValue("C6", "APELLIDO\nPATERNO");
    $prueba->setActiveSheetIndex(0)->setCellValue("D6", "APELLIDO\n MATERNO");
    $prueba->setActiveSheetIndex(0)->setCellValue("E6", "NÚMERO CI");
    $prueba->setActiveSheetIndex(0)->setCellValue("F6", "EXTENSIÓN CI");
    $prueba->setActiveSheetIndex(0)->setCellValue("G6", "CIUDAD DE\nTRABAJO");
    $prueba->setActiveSheetIndex(0)->setCellValue("H6", "EMPRESA / DEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("I6", "CANAL");
    $prueba->setActiveSheetIndex(0)->setCellValue("J6", "CARGO");
    $prueba->setActiveSheetIndex(0)->setCellValue("K6", "EMAIL CORPORATIVO");
    $prueba->setActiveSheetIndex(0)->setCellValue("L6", "TELÉFONO VIVA");
    $prueba->setActiveSheetIndex(0)->setCellValue("M6", "OBSERVACIONES");

    $prueba->getActiveSheet()->getStyle('C6')->getAlignment()->setWrapText(true);
    $prueba->getActiveSheet()->getStyle('D6')->getAlignment()->setWrapText(true);
    $prueba->getActiveSheet()->getStyle('G6')->getAlignment()->setWrapText(true);

    $usuarios = $this->User->find('all', array('recursive' => 0, 'conditions' => array('User.estado' => 'Activo'), 'fields' => array('Persona.nombre', 'Persona.ap_paterno', 'Persona.ap_materno', 'Persona.ci', 'Persona.ext_ci', 'Lugare.nombre', 'Group.name')));
    $contador = 6;
    foreach ($usuarios as $us) {
      $contador++;
      $prueba->getActiveSheet()->getStyle("A$contador:M$contador")->applyFromArray($style3);
      $prueba->setActiveSheetIndex(0)->setCellValue("A$contador", ($contador - 5));
      $prueba->setActiveSheetIndex(0)->setCellValue("B$contador", $us['Persona']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("C$contador", $us['Persona']['ap_paterno']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D$contador", $us['Persona']['ap_materno']);
      $prueba->setActiveSheetIndex(0)->setCellValue("E$contador", $us['Persona']['ci']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F$contador", $us['Persona']['ext_ci']);
      $prueba->setActiveSheetIndex(0)->setCellValue("G$contador", $us['Lugare']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("H$contador", "SS");
      $prueba->setActiveSheetIndex(0)->setCellValue("I$contador", "TRADICIONAL");
      $prueba->setActiveSheetIndex(0)->setCellValue("J$contador", $us['Group']['name']);
    }

    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function exc_hoja_ruteo_d($fecha_ini = null, $fecha_fin = null) {
    $nombre_excel = "Hoja-ruteo.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');

    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 14, 1);
    $style1 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 20, 'bold' => true));
    $prueba->getActiveSheet()->getStyle('A1')->applyFromArray($style1);
    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "HOJA DE RUTEO CONSOLIDADO DISTRIBUIDORES");
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(1, 3, 2, 3);
    $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $style3 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '333333')));
    $style4 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 11), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FF8080')));
    $style5 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFCC99')));
    $style6 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'CCCCFF')));
    $style7 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00FF00')));
    $style8 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '339966')));
    $style9 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $prueba->getActiveSheet()->getStyle('B3:C3')->applyFromArray($style2);
    $prueba->getActiveSheet()->getStyle('D3')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('B4')->applyFromArray($style2);
    $prueba->getActiveSheet()->getStyle('C4')->applyFromArray($style4);
    $prueba->getActiveSheet()->getStyle('C4')->getFont()->setSize(11);

    $prueba->setActiveSheetIndex(0)->setCellValue("B3", "DEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("D3", "SS");
    $prueba->setActiveSheetIndex(0)->setCellValue("B4", "MES");
    $prueba->setActiveSheetIndex(0)->setCellValue("C4", "MAYO");

    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(7, 3, 7, 4);
    $prueba->getActiveSheet()->getStyle('I3:K3')->applyFromArray($style5);
    $prueba->getActiveSheet()->getStyle('J4:K4')->applyFromArray($style5);
    $prueba->setActiveSheetIndex(0)->setCellValue("I3", "MAYO");
    $prueba->setActiveSheetIndex(0)->setCellValue("J3", "1");
    $prueba->setActiveSheetIndex(0)->setCellValue("J4", "2");
    $prueba->setActiveSheetIndex(0)->setCellValue("K3", "SI");
    $prueba->setActiveSheetIndex(0)->setCellValue("K4", "NO");

    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(11, 3, 11, 5);
    $prueba->getActiveSheet()->getStyle('M3:O3')->applyFromArray($style6);
    $prueba->getActiveSheet()->getStyle('N4:O4')->applyFromArray($style6);
    $prueba->getActiveSheet()->getStyle('N5:O5')->applyFromArray($style6);

    $prueba->setActiveSheetIndex(0)->setCellValue("M3", "ESTADO DEL PUNTO:");
    $prueba->setActiveSheetIndex(0)->setCellValue("N3", "1");
    $prueba->setActiveSheetIndex(0)->setCellValue("O3", "ACTIVO");
    $prueba->setActiveSheetIndex(0)->setCellValue("N4", "2");
    $prueba->setActiveSheetIndex(0)->setCellValue("O4", "FUERA DE SERVICIO");
    $prueba->setActiveSheetIndex(0)->setCellValue("N5", "3");
    $prueba->setActiveSheetIndex(0)->setCellValue("O5", "CERRADO");

    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 8, 0, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(1, 8, 1, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(2, 8, 2, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(3, 8, 3, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(4, 8, 4, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(5, 8, 5, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(6, 8, 6, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(7, 8, 7, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(8, 8, 8, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(9, 8, 10, 8);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(11, 8, 11, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(12, 8, 12, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(13, 8, 13, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(14, 8, 14, 9);
    $prueba->getActiveSheet()->getStyle('A8:O8')->applyFromArray($style7);
    $prueba->getActiveSheet()->getStyle('A9:I9')->applyFromArray($style7);
    $prueba->getActiveSheet()->getStyle('L9:O9')->applyFromArray($style7);
    $prueba->getActiveSheet()->getStyle('J9:K9')->applyFromArray($style8);
    $prueba->getActiveSheet()->getStyle('K9')->applyFromArray($style8);
    $prueba->setActiveSheetIndex(0)->setCellValue("A8", "Nª");
    $prueba->setActiveSheetIndex(0)->setCellValue("B8", "FECHA");
    $prueba->setActiveSheetIndex(0)->setCellValue("C8", "DISTRIBUIDOR");
    $prueba->setActiveSheetIndex(0)->setCellValue("D8", "CODIGO SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("E8", "NOMBRE SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("F8", "CODIGO DE MERCADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("G8", "MERCADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("H8", "CAP");
    $prueba->setActiveSheetIndex(0)->setCellValue("I8", "ESTADO DEL\nPUNTO");
    $prueba->setActiveSheetIndex(0)->setCellValue("J8", "CANTIDAD PRE PAGO\nENTREGADA");
    $prueba->setActiveSheetIndex(0)->setCellValue("J9", "SIM MOVIL");
    $prueba->setActiveSheetIndex(0)->setCellValue("k9", "SIM 4G");
    $prueba->setActiveSheetIndex(0)->setCellValue("L8", "TARJETAS\n10");
    $prueba->setActiveSheetIndex(0)->setCellValue("M8", "MICRORECA\nRGA");
    $prueba->setActiveSheetIndex(0)->setCellValue("N8", "# RECARGA");
    $prueba->setActiveSheetIndex(0)->setCellValue("O8", "OBSERVACIONES");
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(34);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(16);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(40);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(9);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(9);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(9);
    $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(9);
    $prueba->getActiveSheet()->getColumnDimension('N')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('O')->setWidth(30);

    $prueba->getActiveSheet()->getStyle('I8')->getAlignment()->setWrapText(true);
    $prueba->getActiveSheet()->getStyle('J8')->getAlignment()->setWrapText(true);
    $prueba->getActiveSheet()->getStyle('L8')->getAlignment()->setWrapText(true);
    $prueba->getActiveSheet()->getStyle('m8')->getAlignment()->setWrapText(true);

    $ventas = $this->Movimiento->find('all', array(
      'recursive' => 0,
      'conditions' => array('Movimiento.created BETWEEN ? AND ?' => array($fecha_ini, $fecha_fin), 'Movimiento.salida !=' => 0, 'Movimiento.escala LIKE' => 'MAYOR'),
      'group' => array('Movimiento.created', 'Movimiento.cliente_id')
      , 'fields' => array("DATE_FORMAT(Movimiento.created,'%m/%d/%Y') as fecha_f", 'Persona.nombre', 'Cliente.cod_dealer', 'Cliente.nombre', 'Cliente.cod_mercado', 'Cliente.mercado', 'Movimiento.capacitacion', 'Movimiento.est_punt')
    ));

    $contador = 9;
    foreach ($ventas as $key => $ve) {
      $contador++;
      $prueba->getActiveSheet()->getStyle("A$contador:O$contador")->applyFromArray($style9);
      $prueba->setActiveSheetIndex(0)->setCellValue("A$contador", ($key + 1));
      $prueba->setActiveSheetIndex(0)->setCellValue("B$contador", $ve[0]['fecha_f']);
      $prueba->setActiveSheetIndex(0)->setCellValue("C$contador", $ve['Persona']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D$contador", $ve['Cliente']['cod_dealer']);
      $prueba->setActiveSheetIndex(0)->setCellValue("E$contador", $ve['Cliente']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F$contador", $ve['Cliente']['cod_mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("G$contador", $ve['Cliente']['mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("H$contador", $ve['Movimiento']['capacitacion']);
      $prueba->setActiveSheetIndex(0)->setCellValue("I$contador", $ve['Movimiento']['est_punt']);
      $prueba->setActiveSheetIndex(0)->setCellValue("J$contador", 0);
      $prueba->setActiveSheetIndex(0)->setCellValue("K$contador", 0);
      $prueba->setActiveSheetIndex(0)->setCellValue("L$contador", 0);
      $prueba->setActiveSheetIndex(0)->setCellValue("M$contador", 0);
      $prueba->setActiveSheetIndex(0)->setCellValue("N$contador", 0);
      $prueba->setActiveSheetIndex(0)->setCellValue("O$contador", "");
    }
    $prueba->getActiveSheet()->setTitle("Hoja de ruteo");
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function hoja_ruteo_d() {

    $datos = $this->request->data['Aux'];
    $fecha_ini = $datos['fecha_ini'];
    $fecha_fin = $datos['fecha_fin'];
    $ventas = $this->Movimiento->find('all', array(
      'recursive' => 0,
      'conditions' => array('Movimiento.created BETWEEN ? AND ?' => array($fecha_ini, $fecha_fin), 'Movimiento.salida <>' => 0, 'Movimiento.escala LIKE' => 'MAYOR'),
      'group' => array('Movimiento.created', 'Movimiento.cliente_id')
    ));
    $this->set(compact('ventas', 'fecha_ini', 'fecha_fin'));
  }

  public function index() {
    $this->User->virtualFields = [
      'nombre_persona' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    ];
    $distribuidores = $this->User->find('list', array(
      'recursive' => 0,
      'conditions' => array('User.group_id' => 2),
      'fields' => array('User.id', "User.nombre_persona")
    ));
    $lugares = $this->Lugare->find('list',array('fields' => 'Lugare.nombre'));
    $this->set(compact('distribuidores','lugares'));
  }

  public function ruteo_diario() {
    if (!empty($this->request->data['Dato']['user_id'])) {
      $idUser = $this->request->data['Dato']['user_id'];
      $this->User->virtualFields = [
        'nombre_persona' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
      ];
      $persona = $this->User->find('first', ['recursive' => 0, 'conditions' => ['User.id' => $idUser], 'fields' => ['User.nombre_persona']]);
      $rutasusuario = $this->Rutasusuario->find('all', [
        'recursive' => -1,
        'conditions' => ['Rutasusuario.user_id' => $idUser],
        'fields' => ['Rutasusuario.ruta_id']
      ]);
      /* debug($rutasusuario);
        exit; */
      $subdealers = [];
      if (!empty($rutasusuario)) {
        $i = 0;
        foreach ($rutasusuario as $ru) {
          $continua = null;
          $cantidad = $this->Cliente->find('count', [
            'recursive' => -1,
            'conditions' => ['Cliente.ruta_id' => $ru['Rutasusuario']['ruta_id']]
          ]);
          //debug(round($cantidad / 30));exit;
          $total = round($cantidad / 30);
          for ($j = 1; $j <= $total; $j++) {
            $condiciones = [];
            $condiciones['Cliente.ruta_id'] = $ru['Rutasusuario']['ruta_id'];
            if (!empty($continua)) {
              $condiciones['Cliente.id >='] = $continua;
            }
            $subdealers[$i] = $ru;
            $subdealers[$i]['subdealers'] = $this->Cliente->find('all', [
              'recursive' => -1,
              'conditions' => $condiciones,
              'limit' => 30
            ]);
            if (!empty($subdealers[$i]['subdealers'][29]['Cliente']['id'])) {
              $continua = $subdealers[$i]['subdealers'][29]['Cliente']['id'];
            } else {
              $continua = null;
            }
            $i++;
          }
        }
      }
    }
    $this->set(compact('subdealers', 'persona'));
  }

  public function excel_ruteo_diario() {

    $mercado = $this->request->data['Dato']['mercado'];
    $idUser = $this->request->data['Dato']['user_id'];

    $this->User->virtualFields = array(
      'nombre_persona' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $user = $this->User->find('first', array(
      'recursive' => 0,
      'conditions' => array('User.id' => $idUser),
      'fields' => array('User.nombre_persona')
    ));
    /* debug($user);
      exit; */
    //debug($idUser);exit;
    $nombre_excel = "Hoja-ruteo.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');

    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 16, 1);
    $style1 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 20, 'bold' => true, 'underline' => 'single'));
    $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $style3 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'CCCCFF')));
    $style4 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFCC99')));
    $style5 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFF00')));
    $style6 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00FF00')));
    $style7 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '339966')));
    $style8 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $prueba->getActiveSheet()->getStyle('A1')->applyFromArray($style1);
    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "HOJA DE RUTEO DIARIO DEL DISTRIBUIDOR");
    $prueba->getActiveSheet()->getStyle('B4:C4')->applyFromArray($style2);
    $prueba->getActiveSheet()->getStyle('K3:M3')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('L4:M4')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('L5:M5')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('L6:M6')->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle('O3:Q3')->applyFromArray($style4);
    $prueba->getActiveSheet()->getStyle('O4:Q4')->applyFromArray($style4);
    $prueba->getActiveSheet()->getStyle('O5:Q5')->applyFromArray($style5);
    $prueba->getActiveSheet()->getStyle('O6:Q6')->applyFromArray($style5);
    $prueba->getActiveSheet()->getStyle('A8:Q9')->applyFromArray($style6);
    $prueba->getActiveSheet()->getStyle('I9:J9')->applyFromArray($style7);
    $prueba->setActiveSheetIndex(0)->setCellValue("B4", "DEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("K3", "ESTADO DEL PUNTO:");
    $prueba->setActiveSheetIndex(0)->setCellValue("L3", '1');
    $prueba->setActiveSheetIndex(0)->setCellValue("L4", '2');
    $prueba->setActiveSheetIndex(0)->setCellValue("L5", '3');
    $prueba->setActiveSheetIndex(0)->setCellValue("L6", '4');
    $prueba->setActiveSheetIndex(0)->setCellValue("M3", "VENDE");
    $prueba->setActiveSheetIndex(0)->setCellValue("M4", "NO VENDE");
    $prueba->setActiveSheetIndex(0)->setCellValue("M5", "NO EXISTE");
    $prueba->setActiveSheetIndex(0)->setCellValue("M6", "CERRADO");

    $prueba->setActiveSheetIndex(0)->setCellValue("O3", "DEJO MATERIAL");
    $prueba->setActiveSheetIndex(0)->setCellValue("O5", "COMUNICO  PROM.");
    $prueba->setActiveSheetIndex(0)->setCellValue("P3", '1');
    $prueba->setActiveSheetIndex(0)->setCellValue("P4", '2');
    $prueba->setActiveSheetIndex(0)->setCellValue("P5", '1');
    $prueba->setActiveSheetIndex(0)->setCellValue("P6", '2');
    $prueba->setActiveSheetIndex(0)->setCellValue("Q3", 'SI');
    $prueba->setActiveSheetIndex(0)->setCellValue("Q4", 'NO');
    $prueba->setActiveSheetIndex(0)->setCellValue("Q5", 'SI');
    $prueba->setActiveSheetIndex(0)->setCellValue("Q6", 'NO');

    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 8, 0, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(1, 8, 1, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(2, 8, 2, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(3, 8, 3, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(4, 8, 4, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(5, 8, 5, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(6, 8, 6, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(7, 8, 7, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(8, 8, 9, 8);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(10, 8, 10, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(11, 8, 11, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(12, 8, 12, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(13, 8, 13, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(14, 8, 14, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(15, 8, 15, 9);
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(16, 8, 16, 9);

    $prueba->setActiveSheetIndex(0)->setCellValue("A8", "FECHA");
    $prueba->setActiveSheetIndex(0)->setCellValue("B8", "DISTRIBUIDOR");
    $prueba->setActiveSheetIndex(0)->setCellValue("C8", "CODIGO SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("D8", "NOMBRE SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("E8", "CODIGO DE MERCADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("F8", "MERCADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("G8", "* ESTADO DEL PUNTO");
    $prueba->setActiveSheetIndex(0)->setCellValue("H8", "LINEA ABONABLE");
    $prueba->setActiveSheetIndex(0)->setCellValue("I8", "CANTIDAD PRE PAGO ENTREGADA");
    $prueba->setActiveSheetIndex(0)->setCellValue("K8", "Q TARJETAS 10");
    $prueba->setActiveSheetIndex(0)->setCellValue("L8", "MICRORECARGA");
    $prueba->setActiveSheetIndex(0)->setCellValue("M8", "DEJO MATERIAL POP?");
    $prueba->setActiveSheetIndex(0)->setCellValue("N8", "COMUNICO PROMOCION?");
    $prueba->setActiveSheetIndex(0)->setCellValue("O8", "OBSERVACIONES");
    $prueba->setActiveSheetIndex(0)->setCellValue("P8", "FIRMA");
    $prueba->setActiveSheetIndex(0)->setCellValue("Q8", "ACLARACION FIRMA");
    $prueba->setActiveSheetIndex(0)->setCellValue("I9", "SIM MOVIL");
    $prueba->setActiveSheetIndex(0)->setCellValue("J9", "SIM 4G");

    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(14);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(19);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(17);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(13);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(13);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(18);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(17);
    $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(19);
    $prueba->getActiveSheet()->getColumnDimension('N')->setWidth(20);
    $prueba->getActiveSheet()->getColumnDimension('O')->setWidth(18);
    $prueba->getActiveSheet()->getColumnDimension('P')->setWidth(11);
    $prueba->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

    $clientes = $this->Cliente->find('all', array(
      'recursive' => -1,
      'conditions' => array('Cliente.cod_mercado' => $mercado)
    ));
    $num = 9;
    foreach ($clientes as $cli) {
      $num++;
      $prueba->getActiveSheet()->getStyle("A$num:Q$num")->applyFromArray($style8);
      $prueba->setActiveSheetIndex(0)->setCellValue("B$num", $user['User']['nombre_persona']);
      $prueba->setActiveSheetIndex(0)->setCellValue("C$num", $cli['Cliente']['num_registro']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D$num", $cli['Cliente']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("E$num", $cli['Cliente']['cod_mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F$num", $cli['Cliente']['mercado']);
    }

    $prueba->getActiveSheet()->setTitle("Hoja de ruteo Diario");
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function excel_rutas_semana() {
    
    $lugar = $this->request->data['Dato']['lugare_id'];
    $rutas = $this->Rutasusuario->find('list', array(
      'recursive' => 0,
      'conditions' => array('User.lugare_id' => $lugar),
      'fields' => 'Rutasusuario.ruta_id',
      'group' => 'Rutasusuario.ruta_id'
    ));

    $sql = "(SELECT ru.user_id FROM rutasusuarios ru WHERE Cliente.ruta_id = ru.ruta_id LIMIT 1)";
    $sql1 = "(SELECT us.persona_id FROM users us WHERE us.id = $sql LIMIT 1)";
    $sql2 = "SELECT CONCAT(pe.nombre,' ',pe.ap_paterno,' ',pe.ap_materno) FROM personas pe WHERE pe.id = $sql1";
    $this->Cliente->virtualFields = array(
      'encargado' => "($sql2)"
    );
    $clientes = $this->Cliente->find('all', array(
      'recursive' => -1,
      'conditions' => array(
        'Cliente.ruta_id' => $rutas
      ),
      'order' => 'Cliente.encargado'
    ));
    
    
    $nombre_excel = "control-rutas-frecue.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');
    $prueba = new PHPExcel();
    $style1 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 11, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFF00')));
    $style3 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 9, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00FF00')));
    $style4 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFF99')));
    $style5 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 9, 'bold' => true), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '993366')));
    $style6 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 8), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 5, 1);
    $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(23);
    $prueba->getActiveSheet()->getStyle("A1:F1")->applyFromArray($style1);
    $prueba->getActiveSheet()->getStyle("G1:L1")->applyFromArray($style2);
    $prueba->getActiveSheet()->getStyle("A2:P2")->applyFromArray($style3);
    $prueba->getActiveSheet()->getStyle("M1")->applyFromArray($style4);
    $prueba->getActiveSheet()->getStyle("M2")->applyFromArray($style4);
    $prueba->getActiveSheet()->getStyle("N2")->applyFromArray($style5);
    
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(9);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(29);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(14);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(23);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('N')->setWidth(7);
    $prueba->getActiveSheet()->getColumnDimension('O')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    
    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "CONTROL DE RUTAS Y FRECUENCIAS - SEMANA ________________");
    $prueba->setActiveSheetIndex(0)->setCellValue("G1", "LUNES");
    $prueba->setActiveSheetIndex(0)->setCellValue("H1", "MARTES");
    $prueba->setActiveSheetIndex(0)->setCellValue("I1", "MIERCOLES");
    $prueba->setActiveSheetIndex(0)->setCellValue("J1", "JUEVES");
    $prueba->setActiveSheetIndex(0)->setCellValue("K1", "VIERNES");
    $prueba->setActiveSheetIndex(0)->setCellValue("L1", "SABADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("M1", "DOMINGO");

    $prueba->setActiveSheetIndex(0)->setCellValue("A2", "CODIGO");
    $prueba->setActiveSheetIndex(0)->setCellValue("B2", "Estado");
    $prueba->setActiveSheetIndex(0)->setCellValue("C2", "NOMBRE");
    $prueba->setActiveSheetIndex(0)->setCellValue("D2", "TIPO DE MERCADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("E2", "DISTRIBUIDOR ENCARGADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("F2", "Ruta");
    $prueba->setActiveSheetIndex(0)->setCellValue("N2", "TOTAL");
    $prueba->setActiveSheetIndex(0)->setCellValue("O2", "MERCADO");
    $prueba->setActiveSheetIndex(0)->setCellValue("P2", "DEALER PADRE");
    
    $num = 2;
    foreach ($clientes as $cli) {
      $num++;
      $prueba->getActiveSheet()->getStyle("A$num:P$num")->applyFromArray($style6);
      $prueba->getActiveSheet()->getStyle("M$num")->applyFromArray($style4);
      $prueba->getActiveSheet()->getStyle("N$num")->applyFromArray($style5);
      
      $prueba->setActiveSheetIndex(0)->setCellValue("A$num", $cli['Cliente']['cod_dealer']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("B$num", "");
      $prueba->setActiveSheetIndex(0)->setCellValue("C$num", $cli['Cliente']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D$num", "TRADICIONAL");
      $prueba->setActiveSheetIndex(0)->setCellValue("E$num", $cli['Cliente']['encargado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F$num", $cli['Cliente']['cod_mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("N$num", 0);
      $prueba->setActiveSheetIndex(0)->setCellValue("O$num", $cli['Cliente']['mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("P$num", "SILVIA SEJAS");
    }

    $prueba->getActiveSheet()->setTitle("CONTROL DE RUTAS Y FRECUENCIAS");
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function ajax_mercado($idUser = null) {
    $rutas = $this->Rutasusuario->find('list', array(
      'recursive' => -1,
      'conditions' => array('Rutasusuario.user_id' => $idUser),
      'fields' => array('Rutasusuario.ruta_id')
    ));
    $mercados = $this->Cliente->find('list', array(
      'recursive' => -1,
      'conditions' => array('Cliente.ruta_id' => $rutas, 'Cliente.cod_mercado !=' => '', 'Cliente.cod_mercado !=' => null),
      'fields' => array('Cliente.cod_mercado', 'Cliente.mercado'),
      'group' => array('Cliente.cod_mercado')
    ));
    //debug($mercados);exit;
    $this->set(compact('mercados'));
  }

}
