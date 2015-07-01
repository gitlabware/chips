<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

class InformesController extends AppController {

  //public $helpers = array('Html', 'Form', 'Session', 'Js');
  public $uses = array('User');
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
    $style1 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'font' => array(
        'size' => 22
        , 'bold' => true
      )
    );
    $prueba->getActiveSheet()->getStyle("C1:k1")->applyFromArray($style1);

    $style2 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'font' => array(
        'size' => 8
        , 'bold' => true
      ),
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $style3 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'font' => array(
        'size' => 8
      ),
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
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

    $objImagen->setPath(WWW_ROOT . 'img' . DS .'logoviva.png');
    $objImagen->setCoordinates('A1');
    $objImagen->setWorksheet($prueba->getActiveSheet());
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(8);
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
    
    
    $style4 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'font' => array(
        'size' => 8
        , 'bold' => true
      ),
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '006837')
      )
    );
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
    
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

}
