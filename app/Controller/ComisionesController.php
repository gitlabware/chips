<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

Class ComisionesController extends AppController {

    public $layout = 'viva';
    public $uses = array('Comisione', 'Excel', 'Cliente');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        if ($this->RequestHandler->responseType() == 'json') {
            $this->RequestHandler->setContent('json', 'application/json');
        }
        //$this->Auth->allow();
    }

    public function index() {

        $excels = $this->Excel->find('all', array(
            'recursive' => -1,
            'conditions' => array('Excel.tipo LIKE' => 'comisiones'),
            'fields' => array('Excel.*')
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
                }else{
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
    
    public function vercomisiones($idExcel = null){
        $comisiones = $this->Comisione->find('all',array(
            'recursive' => -1,
            'conditions' => array('Comisione.excel_id' => $idExcel)
        ));
        
        $excel = $this->Excel->find('first',array(
            'recursive' => -1,
            'conditions' => array('Excel.id' => $idExcel)
        ));
        
        $this->set(compact('comisiones','excel'));
    }

}
