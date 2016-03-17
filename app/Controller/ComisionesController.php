<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));
Class ComisionesController extends AppController{
    
    public $layout = 'viva';
    
    public $uses = array('Comisione','Excel');

    public function index(){
        $excels = $this->Comisione->find('all',array(
            'recursive' => 0,
            'conditions' => array('Excel.tipo LIKE' => 'comisiones'),
            'fields' => array('Excel.*','Comisione.gestion','Comisione.mes'),
            'group' => array('Comisione.excel_id','Comisione.gestion','Comisione.mes')
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
                $this->request->data['Excelg']['tipo'] = "asignacion";

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
            }
        }

        $this->Excel->save($this->data['Excelg']);
        $this->redirect($this->referer());
    }
    
}

