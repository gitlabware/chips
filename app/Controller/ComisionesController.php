<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

Class ComisionesController extends AppController {

    public $layout = 'viva';
    public $uses = array('Comisione', 'Excel', 'Cliente', 'User', 'Rutasusuario');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        if ($this->RequestHandler->responseType() == 'json') {
            $this->RequestHandler->setContent('json', 'application/json');
        }
        //$this->Auth->allow();
    }

    public function index() {

        /* $excels = $this->Comisione->find('all',array(
          'recursive' => 0,
          'conditions' => array('Excel.tipo LIKE' => 'comisiones'),
          'group' => array('Excel.id'),
          'fields' => array('Excel.*','COUNT(Comisione.cliente_id) AS reconocidos','COUNT(Comisione.id) AS registrados'),
          'order' => array('Excel.id DESC')
          )); */

        $sql1 = "(SELECT COUNT(comisiones.id) FROM comisiones WHERE comisiones.excel_id = Excel.id)";
        $sql2 = "(SELECT COUNT(comisiones.id) FROM comisiones WHERE comisiones.excel_id = Excel.id AND !ISNULL(comisiones.cliente_id))";

        $this->Excel->virtualFields = array(
            'registrados' => "$sql1",
            'reconocidos' => "$sql2"
        );
        $excels = $this->Excel->find('all', array(
            'recursive' => -1,
            'conditions' => array('Excel.tipo LIKE' => 'comisiones'),
            'fields' => array('Excel.*'),
            'order' => array('Excel.id DESC'),
            'limit' => 30
        ));


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
                $this->request->data['Excelg']['tipo'] = "comisiones";

                $objLector = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objLector->load("../webroot/files/$nombreExcel");
                $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                if ($total_rows >= 3) {
                    $total_filas = $total_rows - 2;
                } else {
                    $total_filas = 0;
                }
                $this->request->data['Excelg']['total_registros'] = $total_filas;
                $this->request->data['Excelg']['puntero'] = 0;

                $array['gestion'] = $this->request->data['Dato']['gestion']['year'];
                $array['mes'] = $this->request->data['Dato']['mes'];

                $this->request->data['Excelg']['detalles'] = serialize($array);
            }
        }

        $this->Excel->save($this->data['Excelg']);
        $this->redirect($this->referer());
    }

    public function registra_reg_com($idExcel = null) {

        //debug($objPHPExcel);die;
        $excel = $this->Excel->find('first', array(
            'recurisve' => -1,
            'conditions' => array(
                'Excel.id' => $idExcel
            )
        ));

        $array = unserialize($excel['Excel']['detalles']);

        $array_data = array();

        $puntero = ($excel['Excel']['puntero'] + 3);
        $nombre_ex = $excel['Excel']['nombre'];
        $objLector = new PHPExcel_Reader_Excel2007();

        $objPHPExcel = $objLector->load("../webroot/files/$nombre_ex");
        $i = 0;
        while ($excel['Excel']['total_registros'] > 0 && $excel['Excel']['total_registros'] > $excel['Excel']['puntero'] && $i < 100) {

            $row = $objPHPExcel->getActiveSheet()->getRowIterator($puntero)->current();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                if ('A' == $cell->getColumn()) {
                    $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
                } elseif ('B' == $cell->getColumn()) {
                    $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
                } elseif ('C' == $cell->getColumn()) {
                    $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
                } elseif ('D' == $cell->getColumn()) {
                    $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
                }
            }
            if (!empty($array_data['A'])) {

                $cliente = $this->Cliente->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'OR' => array(
                            'Cliente.cod_dealer' => $array_data['A'],
                            'Cliente.num_registro' => $array_data['A']
                        )
                    ),
                    'fields' => array('Cliente.id')
                ));

                if (!empty($cliente['Cliente']['id'])) {
                    $d_comi['cliente_id'] = $cliente['Cliente']['id'];

                    $this->Comisione->deleteAll(array(
                        'Comisione.cliente_id' => $d_comi['cliente_id'],
                        'Comisione.mes' => $array['mes'],
                        'Comisione.gestion' => $array['gestion']
                    ));
                } else {
                    $d_comi['cliente_id'] = NULL;
                }
                $d_comi['mes'] = $array['mes'];
                $d_comi['gestion'] = $array['gestion'];
                $d_comi['codigo'] = $array_data['A'];
                $d_comi['subdealer'] = $array_data['B'];
                $d_comi['zona'] = $array_data['C'];
                $d_comi['monto_a_pagar'] = $array_data['D'];
                $d_comi['excel_id'] = $idExcel;
                $this->Comisione->create();
                $this->Comisione->save($d_comi);
            }

            $d_excel['puntero'] = $excel['Excel']['puntero'] + 1;
            $this->Excel->id = $idExcel;
            $this->Excel->save($d_excel);

            $excel = $this->Excel->find('first', array(
                'recurisve' => -1,
                'conditions' => array(
                    'Excel.id' => $idExcel
                )
            ));

            $i++;
            $puntero++;
        }

        /* debug($row->getRowIndex());
          exit; */
        $array['numero'] = $d_excel['puntero'];
        $array['total'] = $excel['Excel']['total_registros'];

        $this->respond($array, true);
    }

    function respond($message = null, $json = false) {
        if ($message != null) {
            if ($json == true) {
                $this->RequestHandler->setContent('json', 'application/json');
                $message = json_encode($message);
            }
            $this->set('message', $message);
        }
        $this->render('message');
    }

    public function vercomisiones($idExcel = null) {

        $comisiones = $this->Comisione->find('all', array(
            'recursive' => 0,
            'conditions' => array('Comisione.excel_id' => $idExcel),
            'fields' => array('Comisione.*', 'Cliente.nombre')
        ));

        $excel = $this->Excel->find('first', array(
            'recursive' => -1,
            'conditions' => array('Excel.id' => $idExcel)
        ));

        $this->set(compact('comisiones', 'excel'));
    }

    public function eliminar($idComision = null) {
        $this->Comisione->delete($idComision);
        $this->Session->setFlash("Se ha eliminado correctamente la comision!!", 'msgbueno');
        $this->redirect($this->referer());
    }

    public function eliminar_excel($idExcel = null) {
        $this->Excel->delete($idExcel);
        $this->Comisione->deleteAll(array('Comisione.excel_id' => $idExcel));
        $this->Session->setFlash("Se ha eliminado correctamente el excel!!", 'msgbueno');
        $this->redirect($this->referer());
    }

    public function distribuidor($idCliente = null) {
        $this->layout = 'vivadistribuidor';

        $comisiones = $this->Comisione->find('all', array(
            'recursive' => -1,
            'conditions' => array('Comisione.cliente_id' => $idCliente),
            'order' => array('Comisione.id DESC')
        ));
        $cliente = $this->Cliente->find('first', array(
            'recursive' => -1,
            'conditions' => array('Cliente.id' => $idCliente)
        ));
        $this->set(compact('comisiones', 'cliente'));
    }

    public function ajax_comision($idComision = null) {
        $this->layout = 'ajax';
        if (!empty($this->request->data)) {
            $this->Comisione->id = $idComision;
            $this->Comisione->save($this->request->data['Comisione']);
            $this->Session->setFlash("Se ha registrado correctamente la comision!!", 'msgbueno');
            $this->redirect($this->referer());
        }
        $this->Comisione->id = $idComision;
        $this->request->data = $this->Comisione->read();
    }

    public function genera_excel_1($idExcel = null, $idDistribuior = null) {
        $meses = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Sepetiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Disciembre'
        );
        $excel = $this->Excel->find('first', array(
            'recursive' => -1,
            'conditions' => array('Excel.id' => $idExcel)
        ));

        $rutas = $this->Rutasusuario->find('list', array(
            'recurisve' => -1,
            'conditions' => array('Rutasusuario.user_id' => $idDistribuior),
            'fields' => array('Rutasusuario.id', 'Rutasusuario.ruta_id')
        ));
        $comisiones = array();
        if (count($rutas) > 1) {
            $comisiones = $this->Comisione->find('all', array(
                'recursive' => 0,
                'conditions' => array('Cliente.ruta_id' => $rutas)
            ));
        } elseif (count($rutas) == 1) {
            $comisiones = $this->Comisione->find('all', array(
                'recursive' => 0,
                'conditions' => array('Cliente.ruta_id' => current($rutas))
            ));
        }
        $distribuidor = $this->User->find('first', array(
            'recurisve' => 0,
            'conditions' => arraY('User.id' => $idDistribuior),
            'fields' => array('Persona.nombre')
        ));

        $array = unserialize($excel['Excel']['detalles']);
        $mes = strtoupper($meses[(int) $array['mes']]);
        $gestion = $array['gestion'];

        $nombre_excel = "comisiones de $mes $gestion.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
        header('Cache-Control: max-age=0');

        $borders3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                //,'color' => array('argb' => 'FFFF0000')
                )
            ),
            'font' => array(
                'size' => 8
                , 'bold' => true
            //,'color' => array('argb' => 'FFFF0000')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b4edb4')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $borders2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'size' => 10
            )
        );
        $prueba = new PHPExcel();
        $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(7);
        $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(6);
        $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(9);
        $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(9);
        $prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 12, 1);
        $style1 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 20, 'bold' => true));
        $prueba->getActiveSheet()->getStyle("A1:M1")->applyFromArray($style1);
        $nombre_dis = strtoupper($distribuidor['Persona']['nombre']);
        $prueba->setActiveSheetIndex(0)->setCellValue("A1", "COMISIONES SUBDEALERS $mes $gestion ($nombre_dis)");
        //$prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 1, 3);
        //$prueba->getActiveSheet()->getStyle('A1:J1')->applyFromArray($borders);
        //$prueba->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setWrapText(true); 
        $prueba->getActiveSheet()->getStyle('A2:M2' . $prueba->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $prueba->getActiveSheet()->getStyle('A2:M2')->applyFromArray($borders3);
        $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(28);
        $prueba->getActiveSheet()->getRowDimension(2)->setRowHeight(31);

        $prueba->setActiveSheetIndex(0)->setCellValue("A2", "COD");
        $prueba->setActiveSheetIndex(0)->setCellValue("B2", "NOMBRE SUBDEALER");
        $prueba->setActiveSheetIndex(0)->setCellValue("C2", "ZONA");
        $prueba->setActiveSheetIndex(0)->setCellValue("D2", "C/FACTURA");
        $prueba->setActiveSheetIndex(0)->setCellValue("E2", "FACTURA S/N");
        $prueba->setActiveSheetIndex(0)->setCellValue("F2", "DESCUENTO");
        $prueba->setActiveSheetIndex(0)->setCellValue("G2", "S/FACTURA");
        $prueba->setActiveSheetIndex(0)->setCellValue("H2", "AUMENTO");
        $prueba->setActiveSheetIndex(0)->setCellValue("I2", "TARJETAS DE 10 BS.");
        $prueba->setActiveSheetIndex(0)->setCellValue("J2", "NOMBRE");
        $prueba->setActiveSheetIndex(0)->setCellValue("K2", "FIRMA");
        $prueba->setActiveSheetIndex(0)->setCellValue("L2", "FECHA");
        $prueba->setActiveSheetIndex(0)->setCellValue("M2", "CELULAR");

        $prueba->getActiveSheet()->setTitle("Comisiones de $mes $gestion");


        $cont = 2;
        foreach ($comisiones as $co) {
            $cont++;
            $prueba->getActiveSheet()->getRowDimension($cont)->setRowHeight(26);
            $prueba->getActiveSheet()->getStyle("A$cont:M$cont")->applyFromArray($borders2);
            //$prueba->getActiveSheet()->getStyle("D$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
            $prueba->setActiveSheetIndex(0)->setCellValue("A" . $cont, $co['Comisione']['codigo']);
            $prueba->setActiveSheetIndex(0)->setCellValue("B" . $cont, $co['Comisione']['subdealer']);
            $prueba->setActiveSheetIndex(0)->setCellValue("C" . $cont, $co['Comisione']['zona']);
            $prueba->setActiveSheetIndex(0)->setCellValue("D" . $cont, $co['Comisione']['monto_a_pagar']);
            $prueba->setActiveSheetIndex(0)->setCellValue("E" . $cont, "");
            $prueba->setActiveSheetIndex(0)->setCellValue("F" . $cont, '=PRODUCT(D' . $cont . '*0.16)');
            $prueba->setActiveSheetIndex(0)->setCellValue("G" . $cont, '=SUM(D' . $cont . '-F' . $cont . ')');
            $prueba->setActiveSheetIndex(0)->setCellValue("H" . $cont, "");
            $prueba->setActiveSheetIndex(0)->setCellValue("I" . $cont, "");
            $prueba->setActiveSheetIndex(0)->setCellValue("J" . $cont, "");
            $prueba->setActiveSheetIndex(0)->setCellValue("K" . $cont, "");
            $prueba->setActiveSheetIndex(0)->setCellValue("L" . $cont, "");
            $prueba->setActiveSheetIndex(0)->setCellValue("M" . $cont, "");
        }
        $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function genera_excel_2($idExcel = null) {
        $meses = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Sepetiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Disciembre'
        );
        $excel = $this->Excel->find('first', array(
            'recursive' => -1,
            'conditions' => array('Excel.id' => $idExcel)
        ));
        $this->Comisione->virtualFields = array(
            'factura_aux' => "(IF(Comisione.factura = 1,'SI','NO'))"
        );
        $comisiones = $this->Comisione->find('all', array(
            'recursive' => -1,
            'conditions' => array('Comisione.excel_id' => $idExcel)
        ));

        $array = unserialize($excel['Excel']['detalles']);
        $mes = strtoupper($meses[(int) $array['mes']]);
        $gestion = $array['gestion'];

        $nombre_excel = "comisiones de $mes $gestion.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
        header('Cache-Control: max-age=0');

        $borders3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                //,'color' => array('argb' => 'FFFF0000')
                )
            ),
            'font' => array(
                'size' => 8
                //, 'bold' => true
                , 'color' => array('rgb' => 'ffffff')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '666666')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $borders2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'size' => 10
            )
        );
        $prueba = new PHPExcel();
        $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(34);
        $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(34);
        $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(11);
        $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(11);
        //$prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 12, 1);
        /* $style1 = array(
          'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
          'font' => array('size' => 20, 'bold' => true)
          ); */
        //$prueba->getActiveSheet()->getStyle("A1:M1")->applyFromArray($style1);
        //$prueba->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 1, 3);
        //$prueba->getActiveSheet()->getStyle('A1:J1')->applyFromArray($borders);
        //$prueba->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setWrapText(true); 
        $prueba->getActiveSheet()->getStyle('A1:M1' . $prueba->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $prueba->getActiveSheet()->getStyle('A1:M1')->applyFromArray($borders3);
        $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(45);
        //$prueba->getActiveSheet()->getRowDimension(2)->setRowHeight(31);

        $prueba->setActiveSheetIndex(0)->setCellValue("A1", "COD");
        $prueba->setActiveSheetIndex(0)->setCellValue("B1", "NOMBRE SUBDEALER");
        $prueba->setActiveSheetIndex(0)->setCellValue("C1", "ZONA");
        $prueba->setActiveSheetIndex(0)->setCellValue("D1", "MONTO COMISIONABLE");
        $prueba->setActiveSheetIndex(0)->setCellValue("E1", "FACTURA");
        $prueba->setActiveSheetIndex(0)->setCellValue("F1", "DESCUENTO DE LEY 15.5% SI CORESPONDE");
        $prueba->setActiveSheetIndex(0)->setCellValue("G1", "TOTAL MONTO A PAGAR");
        $prueba->setActiveSheetIndex(0)->setCellValue("H1", "TARJETA 10 BS.");
        $prueba->setActiveSheetIndex(0)->setCellValue("I1", "CIUDAD");
        $prueba->setActiveSheetIndex(0)->setCellValue("J1", "FECHA DEL PAGO");
        $prueba->setActiveSheetIndex(0)->setCellValue("K1", "PERSONA QUE RECIBIÓ EL PAGO(PREVIA AUTORIZACION DEL PROPIETARIO)");
        $prueba->setActiveSheetIndex(0)->setCellValue("L1", "CARGO y/o RELACION");
        $prueba->setActiveSheetIndex(0)->setCellValue("M1", "ESTATUS (PAGADO/PENDIENTE)");

        $prueba->getActiveSheet()->setTitle("Comisiones de $mes $gestion");


        $cont = 1;
        foreach ($comisiones as $co) {
            $cont++;
            //$prueba->getActiveSheet()->getRowDimension($cont)->setRowHeight(26);
            $prueba->getActiveSheet()->getStyle("A$cont:M$cont")->applyFromArray($borders2);
            //$prueba->getActiveSheet()->getStyle("D$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
            $prueba->setActiveSheetIndex(0)->setCellValue("A" . $cont, $co['Comisione']['codigo']);
            $prueba->setActiveSheetIndex(0)->setCellValue("B" . $cont, $co['Comisione']['subdealer']);
            $prueba->setActiveSheetIndex(0)->setCellValue("C" . $cont, $co['Comisione']['zona']);
            $prueba->setActiveSheetIndex(0)->setCellValue("D" . $cont, $co['Comisione']['monto_a_pagar']);

            $prueba->setActiveSheetIndex(0)->setCellValue("F" . $cont, '=PRODUCT(D' . $cont . '*0.16)');
            if ($co['Comisione']['factura'] == 1) {
                $monto_apagar = $co['Comisione']['monto_a_pagar'];
                $monto_apagar_aux = $co['Comisione']['monto_a_pagar'];
            } else {
                $monto_apagar = '=SUM(D' . $cont . '-F' . $cont . ')';
                $monto_apagar_aux = round(($co['Comisione']['monto_a_pagar'] - ($co['Comisione']['monto_a_pagar']*0.16) ),2);
            }
            $prueba->setActiveSheetIndex(0)->setCellValue("G" . $cont, $monto_apagar);
            $prueba->setActiveSheetIndex(0)->setCellValue("I" . $cont, "El Alto");
            
            $prueba->setActiveSheetIndex(0)->setCellValue("M" . $cont, "PENDIENTE");
            if ($co['Comisione']['pagado'] == 1) {
                $prueba->setActiveSheetIndex(0)->setCellValue("E" . $cont, $co['Comisione']['factura_aux']);
                $prueba->setActiveSheetIndex(0)->setCellValue("H" . $cont, round($monto_apagar_aux/10));
                $prueba->setActiveSheetIndex(0)->setCellValue("J" . $cont, $co['Comisione']['modified']);
                $prueba->setActiveSheetIndex(0)->setCellValue("K" . $cont, $co['Comisione']['subdealer']);
                $prueba->setActiveSheetIndex(0)->setCellValue("L" . $cont, "PROPIETARI@");
                $prueba->setActiveSheetIndex(0)->setCellValue("M" . $cont, "PAGADO");
            }



            
        }
        $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function distribuidores($idExcel = null) {

        $excel = $this->Excel->find('first', array(
            'recursive' => -1,
            'conditions' => array('Excel.id' => $idExcel)
        ));

        $this->User->virtualFields = array(
            'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
        );

        $distribuidores = $this->User->find('all', array(
            'recursive' => 0,
            'conditions' => array('User.group_id' => 2),
            'fields' => array('User.id', 'User.nombre_completo')
        ));
        $gestion = unserialize($excel['Excel']['detalles']);

        $this->set(compact('excel', 'distribuidores', 'gestion'));

        //debug($distribuidores);exit;
    }

}
