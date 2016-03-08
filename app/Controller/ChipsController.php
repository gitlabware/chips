<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

class ChipsController extends AppController {

  //public $helpers = array('Html', 'Form', 'Session', 'Js');
  public $uses = array('Chip', 'Excel', 'Chipstmp', 'User', 'Activado', 'Cliente', 'Precio', 'Ventaschip','Meta');
  public $layout = 'viva';
  public $components = array('RequestHandler', 'DataTable', 'Montoliteral');

  public function beforeFilter() {
    parent::beforeFilter();
    if ($this->RequestHandler->responseType() == 'json') {
      $this->RequestHandler->setContent('json', 'application/json');
    }
    //$this->Auth->allow();
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

  public function subirexcel() {
    $excels = $this->Excel->find('all', array(
      'order' => array('Excel.id DESC'),
      'conditions' => array('tipo' => array('asignacion', 'activacion')),
      'limit' => 30));
    $this->set(compact('excels'));
    //debug($chips);exit;
  }

  public function entregaunsim() {
    //debug($this->data);exit;
    $codigo = $this->data['Usuario']['149'];
    $id = $this->data['Usuario']['id'];
    $this->data = "";
    $fecha = date('Y-m-d');
    $this->Chip->id = $id;
    $this->request->data['Chip']['fechaentrega'] = $fecha;
    $this->request->data['Chip']['149'] = $codigo;
    //debug($this->data);exit;
    if ($this->Chip->save($this->data)) {

      $this->redirect(array('action' => 'subirexcel'));
    }
  }

  public function buscasse() {

    //$this->layout = "ajaxcrt";
    //debug($this->data);exit;
    $cel = $this->data['Usuario']['celular'];
    //echo $cel;
    $en_sse = $this->Chip->find('all', array('conditions' => array('Chip.telefono like' => "%$cel%", 'Chip.149' => null)));
    //debug($en_sse);exit;
    $this->set(compact('en_sse'));
  }

  public function noentregarsims() {
    //debug($this->data);
    $codigos = $this->request->data['Chip']['codigos'];
    $cod = explode(",", $codigos);
    for ($i = 0; $i < count($cod); $i++) {
      //echo "El codigo de mierda es: "+$cod[$i]."<br />";
      $this->Chip->id = $cod[$i];
      $this->request->data['Chip']['fechaentrega'] = null;
      $this->request->data['Chip']['149'] = null;
      $this->Chip->save($this->data);
    }
    $this->redirect(array('action' => 'subirexcel'));
    //debug($cod);
  }

  public function simsentregados($id = null) {

    //$sims_entregados = $this->Chip->find('all', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149 !=' => null)));
    $sims_entregados = $this->Chip->find('all', array('conditions' => array('Chip.excel_id' => $id)));
    $cant_sims_entregados = $this->Chip->find('count', array('conditions' => array('Chip.excel_id' => $id)));
    $dealers = $this->Chip->find('all', array(
      'conditions' => array('Chip.excel_id' => $id),
      'fields' => array('count(Chip.id) as cantidad', 'Chip.cliente'),
      'group' => array('Chip.cliente')));
    $this->set(compact('sims_entregados', 'cant_sims_entregados', 'dealers'));
  }

  public function verexcels() {
    $excels = $this->Excel->find('all', array('order' => array('Excel.id DESC')));
    $this->set(compact('excels'));
  }

  public function simsine($id = null) {

    $sims_sin_entregar = $this->Chip->find('all', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149' => null), 'limit' => 100));
    $cant_sims_sin_entregar = $this->Chip->find('count', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149' => null)));
    $this->set(compact('sims_sin_entregar', 'cant_sims_sin_entregar'));
  }

  public function noentregar() {

    //debug($this->data);exit;
    //$i=0;

    foreach ($this->data as $d) {
      //echo $d;
      //$i++;
      //echo $i;
      if ($d['Chip']["id"] != 0) {
        //echo 'este es el id a borrar: '.$d['Chip']["id"];
        $id = $d['Chip']["id"];
        $this->Chip->id = $id;
        $this->request->data['Chip']['fechaentrega'] = null;
        $this->request->data['Chip']['149'] = null;
        $this->Chip->save($this->data);
        //
        //}
      }
    }
    $this->redirect(array('action' => 'subirexcel'));
  }

  public function entregachips($id = null) {

    $excel = $this->Excel->findById($id);
    $chipnoentregados = $this->Chip->find('count', array('conditions' => array(
        'Chip.excel_id' => $id,
        'Chip.fechaentrega' => null,
        'Chip.149' => null)));
    //debug($chipnoentregados);
    $this->set(compact('chipnoentregados', 'excel'));
  }

  public function entregar($id = null) {

    $chipnoentregados = $this->Chip->find('all', array('conditions' => array(
        'Chip.excel_id' => $id,
        'Chip.fechaentrega' => null,
        'Chip.149' => null)));
    //debug($chipnoentregados);
    $this->set(compact('chipnoentregados'));
  }

  public function muestraentregados($datos = null) {

    //debug($datos);
  }

  public function guardaentregachips() {

    $fecha = date('Y-m-d');
    //debug($this->data);exit;
    $id_excel = $this->request->data['Entrega']['id'];

    $cant = $this->request->data['Entrega']['cantidad'];

    $cod_149 = $this->request->data['Entrega']['codigo'];

    if (!empty($this->data)) {

      $chips = $this->Chip->find('all', array('conditions' => array('Chip.fechaentrega =' => null, 'Chip.excel_id' => $id_excel), 'limit' => $cant));
    }

    //debug($chips);exit;

    $ids = array();

    $i = 0;

    foreach ($chips as $c) {

      $ids[$i] = $c['Chip']['id'];

      $i++;
    }

    $this->request->data['Chip']['fechaentrega'] = $fecha;

    $this->request->data['Chip']['149'] = $cod_149;


    for ($c = 0; $c < count($ids); $c++) {

      $id = $ids[$c];

      $this->Chip->id = $id;

      $this->Chip->save($this->data);
    }

    $chipsentre = $this->Chip->find('all', array('conditions' => array('Chip.id' => $ids)));

    $this->set(compact('chipsentre'));
  }

  public function detallechips($id = null) {

    $sims = $this->Chip->find('all', array('conditions' => array('Chip.excel_id' => $id), 'limit' => 100));
    $sims_entregados = $this->Chip->find('all', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149 !=' => null)));
    $sims_sin_entregar = $this->Chip->find('all', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149' => null), 'limit' => 100));

    $cant_sims = $this->Chip->find('count', array('conditions' => array('Chip.excel_id' => $id)));
    $cant_sims_entregados = $this->Chip->find('count', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149 !=' => null)));
    $cant_sims_sin_entregar = $this->Chip->find('count', array('conditions' => array('Chip.excel_id' => $id, 'Chip.149' => null)));

    //debug($cant_sims_sin_entregar);exit;
    $this->set(compact('sims', 'sims_entregados', 'sims_sin_entregar', 'cant_sims', 'cant_sims_entregados', 'cant_sims_sin_entregar'));
    //debug($sims);exit;
  }

  public function autocompletado() {
    
  }

  public function guardaexcelactivados() {
    //debug($this->request->data);die;
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
        $this->request->data['Excelg']['tipo'] = "activacion";



        $objLector = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objLector->load("../webroot/files/$nombreExcel");
        $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        if ($total_rows >= 2) {
          $total_filas = $total_rows - 1;
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

  public function registra_reg_chips($idExcel = null) {

    //debug($objPHPExcel);die;
    $excel = $this->Excel->find('first', array(
      'recurisve' => -1,
      'conditions' => array(
        'Excel.id' => $idExcel
      )
    ));

    $array_data = array();

    if ($excel['Excel']['tipo'] == 'asignacion') {

      $puntero = ($excel['Excel']['puntero'] + 3);
      $nombre_ex = $excel['Excel']['nombre'];
      $objLector = new PHPExcel_Reader_Excel2007();

      $objPHPExcel = $objLector->load("../webroot/files/$nombre_ex");
      $i = 0;
      while ($excel['Excel']['total_registros'] > 0 && $excel['Excel']['total_registros'] > $excel['Excel']['puntero'] && $i < 200) {
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
          } elseif ('E' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('F' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('G' == $cell->getColumn()) {
            $fechaExcel = $cell->getCalculatedValue();
            $array_data[$cell->getColumn()] = date('Y-m-d', (($fechaExcel - 25568) * 86400));
          }
        }
        if (!empty($array_data['E'])) {
          $verifica_tel = $this->Chip->find('first', array('conditions' => array('Chip.telefono' => $array_data['E'],'Chip.fecha' => $array_data['G'])));
          if (empty($verifica_tel)) {
            $this->request->data['Chip']['excel_id'] = $idExcel;
            $this->request->data['Chip']['cantidad'] = $array_data['A'];
            $this->request->data['Chip']['tipo_sim'] = $array_data['B'];
            $this->request->data['Chip']['sim'] = $array_data['C'];
            $this->request->data['Chip']['imsi'] = $array_data['D'];
            $this->request->data['Chip']['telefono'] = $array_data['E'];
            $this->request->data['Chip']['fecha'] = $array_data['G'];
            $this->Chip->create();
            $this->Chip->save($this->request->data['Chip']);
          }
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
    } else {

      $puntero = ($excel['Excel']['puntero'] + 2);
      $nombre_ex = $excel['Excel']['nombre'];
      $objLector = new PHPExcel_Reader_Excel2007();

      $objPHPExcel = $objLector->load("../webroot/files/$nombre_ex");
      $i = 0;
      while ($excel['Excel']['total_registros'] > 0 && $excel['Excel']['total_registros'] > $excel['Excel']['puntero'] && $i < 200) {
        $row = $objPHPExcel->getActiveSheet()->getRowIterator($puntero)->current();
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        foreach ($cellIterator as $cell) {

          if ('A' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('B' == $cell->getColumn()) {
            $fechaExcel = explode('/', $cell->getCalculatedValue());
            if (count($fechaExcel) > 1) {
              $array_data[$cell->getColumn()] = $fechaExcel[2] . '-' . $fechaExcel[0] . '-' . $fechaExcel[1];
            } else {
              $array_data[$cell->getColumn()] = date('Y-m-d', (($cell->getCalculatedValue() - 25568) * 86400));
            }
          } elseif ('C' == $cell->getColumn()) {
            $fechaExcel = explode('/', $cell->getCalculatedValue());
            if (count($fechaExcel) > 1) {
              /* if(strlen($fechaExcel[0]) == 1){
                $fechaExcel[0] = '0'.$fechaExcel[0];
                }
                if(strlen($fechaExcel[1]) == 1){
                $fechaExcel[1] = '0'.$fechaExcel[1];
                } */
              $array_data[$cell->getColumn()] = $fechaExcel[2] . '-' . $fechaExcel[0] . '-' . $fechaExcel[1];
            } else {
              $array_data[$cell->getColumn()] = date('Y-m-d', (($cell->getCalculatedValue() - 25568) * 86400));
            }
          } elseif ('D' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('E' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('F' == $cell->getColumn()) {

            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('G' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('H' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('I' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('J' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('K' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('L' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('M' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('N' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('O' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('P' == $cell->getColumn()) {
            $array_data[$cell->getColumn()] = $cell->getCalculatedValue();
          }
        }


        if (!empty($array_data['F'])) {
          $verifica_tel = $this->Activado->find('first', array('conditions' => array('Activado.phone_number' => $array_data['F'],'Activado.fecha_act' => $array_data['B'])));
          if (empty($verifica_tel)) {

            $da_acti['ciudad_nro_tel'] = $array_data['A'];
            $da_acti['fecha_act'] = $array_data['B'];
            $da_acti['fecha_doc'] = $array_data['C'];
            $da_acti['plan_code'] = $array_data['D'];
            $da_acti['description'] = $array_data['E'];
            $da_acti['phone_number'] = $array_data['F'];
            $da_acti['dealer_code'] = $array_data['G'];
            $da_acti['dealer'] = $array_data['H'];
            $da_acti['dealer_nom_act'] = $array_data['I'];
            $da_acti['subdealer_code'] = $array_data['J'];
            $da_acti['subdealer'] = $array_data['K'];
            $da_acti['subdealer_nom_act'] = $array_data['L'];
            $da_acti['canal_m'] = $array_data['M'];
            $da_acti['canal_n'] = $array_data['N'];
            $da_acti['inspector'] = $array_data['O'];
            $da_acti['comercial'] = $array_data['P'];
            $da_acti['excel_id'] = $idExcel;
            $this->Activado->create();
            $this->Activado->save($da_acti);
          }
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
    }

    /* debug($row->getRowIndex());
      exit; */
    $array['numero'] = $d_excel['puntero'];
    $array['total'] = $excel['Excel']['total_registros'];
    $this->respond($array, true);
  }

  public function entregarsims($id = null) {

    $excel = $this->Excel->findById($id);

    $chipnoentregados = $this->Chip->find('count', array('conditions' => array(
        'Chip.excel_id' => $id,
        'Chip.fechaentrega' => null,
        'Chip.149' => null)));
    //debug($chipnoentregados);
    $this->set(compact('chipnoentregados', 'id', 'excel'));
  }

  public function index() {

    $archivo = 'http://localhost/inventario/app/webroot/files/Libro6.xlsx';
    $chips = $this->Chip->find('all');
    //debug($chips);
    //debug($archivo);
    $this->set(compact('chips'));
    $objLector = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $objLector->load("../Vendor/demo.xlsx");
    //$objLector = PHPExcel_IOFactory::load("../Vendor/Libro6.xlsx");
    //$objExcel->setActiveSheetIndex(0);
    //$val = $objExcel->getActiveSheet()->getCell('22252335')->getValue();
    //$val = $objExcel->getActiveSheet()->getCell();
    //$datos = $objExcel->getActiveSheet(0)->getCell('FV');
    //$datocol = $objExcel->getCell('FV');
    //$cell = $objExcel->getce('E', '1');
    //$val = $cell->getValue();
    $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
    $array_data = array();
    foreach ($rowIterator as $row) {
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
      if (1 == $row->getRowIndex())
        continue; //skip first row
      $rowIndex = $row->getRowIndex();
      $array_data[$rowIndex] = array(
        'A' => '',
        'B' => '',
        'C' => '',
        'D' => '',
        'E' => '',
        'F' => '',
        'G' => '');
      foreach ($cellIterator as $cell) {
        if ('A' == $cell->getColumn()) {
          $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
        } else
        if ('B' == $cell->getColumn()) {
          $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
        } else
        if ('C' == $cell->getColumn()) {
          $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
        } else
        if ('D' == $cell->getColumn()) {
          $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
        } else
        if ('E' == $cell->getColumn()) {
          $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
        } else
        if ('F' == $cell->getColumn()) {
          $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
        } else
        if ('G' == $cell->getColumn()) {
          $fecha = $cell->getCalculatedValue();
          $time = PHPExcel_Shared_Date::ExcelToPHP($fecha);
          $fecha_php = date('Y-m-d', $time);
          $array_data[$rowIndex][$cell->getColumn()] = $fecha_php;
        }
      }
    }

    $datos = array();
    $i = 0;
    foreach ($array_data as $d) {
      $this->request->data[$i]['Chip']['numexcel'] = $d['A'];
      $this->request->data[$i]['Chip']['num'] = $d['B'];
      $this->request->data[$i]['Chip']['sim'] = $d['C'];
      $this->request->data[$i]['Chip']['telefono'] = $d['D'];
      $this->request->data[$i]['Chip']['fv'] = $d['E'];
      $fecha_mod = str_replace("\'", "", $d['F']);
      $this->request->data[$i]['Chip']['cliente'] = $fecha_mod;
      $this->request->data[$i]['Chip']['fecha'] = $d['G'];
      $i++;
    }
    //debug($this->request->data);die;

    if ($this->Chip->saveMany($this->data)) {

      echo 'registro corectamente';
    } else {
      echo 'no se pudo guardar';
    }
    //debug($array_data);
    //debug($this->data);
  }

  public function asigna_distrib($idUser = null) {

    $this->request->data['Dato']['distribuidor_id'] = $idUser;
    $sql2 = "SELECT fecha_entrega_d FROM chips WHERE distribuidor_id = User.id ORDER BY fecha_entrega_d DESC LIMIT 1";
    $sql = "SELECT COUNT(*) FROM chips ch,activados ac WHERE ch.telefono = ac.phone_number AND ch.distribuidor_id = User.id AND ch.fecha_entrega_d = ($sql2)";
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT('(',($sql),') ',Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $distribuidores = $this->User->find('list', array(
      'recursive' => 0,
      'fields' => array('User.id', 'User.nombre_completo', 'Group.name'),
      'conditions' => array('User.group_id' => array(2, 7))
    ));
    //debug($distribuidores);exit;
    if ($this->RequestHandler->responseType() == 'json') {
      /* $editar = '<button class="button orange-gradient compact icon-pencil" type="button" onclick="editarc(' . "',Cliente.id,'" . ')">Editar</button>';
        $elimina = '<button class="button red-gradient compact icon-cross-round" type="button" onclick="eliminarc(' . "',Cliente.id,'" . ')">Eliminar</button>';
        $acciones = "$editar $elimina";
        $this->Chip->virtualFields = array(
        'activacion' => ""
        ); */
      $this->paginate = array(
        'fields' => array('Chip.id', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha', 'Chip.factura', 'Chip.caja'),
        'recursive' => 0,
        'order' => 'Chip.created'
        , 'conditions' => array('Chip.distribuidor_id' => NULL, 'Chip.cliente_id' => NULL, '(ISNULL(   (SELECT activados.id FROM activados WHERE activados.phone_number = Chip.telefono) ))')
      );
      $this->DataTable->fields = array('Chip.id', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha', 'Chip.factura', 'Chip.caja');
      $this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('chips', $this->DataTable->getResponse());
      $this->set('_serialize', 'chips');
    }
    $this->set(compact('distribuidores'));
  }

  public function registra_asignado() {
    if (!empty($this->request->data['Dato']['rango_ini']) && !empty($this->request->data['Dato']['cantidad'])) {
      $rango_ini = $this->request->data['Dato']['rango_ini'];
      $cantidad = $this->request->data['Dato']['cantidad'];
      $chips = $this->Chip->find('all', array(
        'recursive' => -1,
        'order' => 'Chip.id', 'limit' => $cantidad, 'fields' => array('Chip.id'),
        'conditions' => array('Chip.id >=' => $rango_ini, 'Chip.distribuidor_id' => NULL, '(ISNULL(   (SELECT activados.id FROM activados WHERE activados.phone_number = Chip.telefono) ))', 'Chip.cliente_id' => NULL)
      ));
      /* debug($chips);
        exit; */
      foreach ($chips as $ch) {
        $this->Chip->id = $ch['Chip']['id'];
        $dato['Chip']['fecha_entrega_d'] = $this->request->data['Dato']['fecha_entrega_d'];
        $dato['Chip']['distribuidor_id'] = $this->request->data['Dato']['distribuidor_id'];
        $this->Chip->save($dato['Chip']);
      }
      $this->Session->setFlash('Se asigno correctamente', 'msgbueno');
    } else {
      $this->Session->setFlash('No se pudo asignar!!', 'msgerror');
    }
    $this->redirect(array('action' => 'asigna_distrib'));
  }

  public function rango_nuemros() {
    $this->layout = 'ajax';

    $numeros = "";
    if (!empty($this->request->data['Dato']['rango_ini']) && !empty($this->request->data['Dato']['cantidad'])) {
      $rango_ini = $this->request->data['Dato']['rango_ini'];
      $cantidad = $this->request->data['Dato']['cantidad'];
      $chips = $this->Chip->find('all', array(
        'recursive' => -1,
        'order' => 'Chip.id', 'limit' => $cantidad, 'fields' => array('Chip.id', 'Chip.telefono'),
        'conditions' => array('Chip.id >=' => $rango_ini, 'Chip.distribuidor_id' => NULL, '(ISNULL(   (SELECT activados.id FROM activados WHERE activados.phone_number = Chip.telefono) ))', 'Chip.cliente_id' => NULL)
      ));
      /* debug($chips);
        exit; */
      //debug($chips);exit;
      foreach ($chips as $ch) {
        if (empty($numeros)) {
          $numeros = $ch['Chip']['telefono'];
        } else {
          $numeros = "$numeros, " . $ch['Chip']['telefono'];
        }
      }
    }

    $this->set(compact('numeros'));
  }

  public function asignados() {
    $sql = "SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) FROM personas p WHERE p.id = Distribuidor.persona_id";
    $this->Chip->virtualFields = array(
      'nombre_dist' => "CONCAT(($sql))"
    );
    $entregados = $this->Chip->find('all', array(
      'fields' => array('Chip.fecha_entrega_d', 'Chip.distribuidor_id', 'COUNT(*) as num_chips', 'Chip.nombre_dist')
      , 'recursive' => 0
      , 'conditions' => array('Chip.distribuidor_id !=' => NULL)
      , 'group' => array('Chip.fecha_entrega_d', 'distribuidor_id')
      , 'order' => 'fecha_entrega_d DESC'
      , 'LIMIT' => 50
    ));
    //debug($entregados);exit;
    $this->set(compact('entregados'));
  }

  public function detalle_entrega($idEcel = null,$fecha = null, $idDistribuidor = null) {
    $distribuidor = $this->User->findByid($idDistribuidor, null, null, 0);
    $entregados = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array('Chip.fecha_entrega_d' => $fecha, 'Chip.distribuidor_id' => $idDistribuidor)
    ));
    $this->set(compact('entregados', 'fecha', 'distribuidor', 'idDistribuidor'));
  }

  public function cancela_entrega_id($idChip = null) {
    $this->Chip->id = $idChip;
    $dchip['distribuidor_id'] = null;
    $this->Chip->save($dchip);
    $this->Session->setFlash('Se cancelo correctamente!!!', 'msgbueno');
    $this->redirect($this->referer());
  }

  public function cancela_entrega($fecha = null, $idDistribuidor = null) {
    $entregas = $this->Chip->find('all', array(
      'fields' => array('Chip.id'),
      'conditions' => array('Chip.fecha_entrega_d' => $fecha, 'Chip.distribuidor_id' => $idDistribuidor)
    ));
    foreach ($entregas as $en) {
      $this->Chip->id = $en['Chip']['id'];
      $dchip['distribuidor_id'] = NULL;
      $this->Chip->save($dchip);
    }
    $this->Session->setFlash('Se cancelo correctamente!!!', 'msgbueno');
    $this->redirect($this->referer());
  }

  public function cancela_asignado() {
    if (!empty($this->request->data['Dato'])) {
      $rango_ini = $this->request->data['Dato']['rango_ini'];
      $cantidad = $this->request->data['Dato']['cantidad'];
      $idDistribuidor = $this->request->data['Dato']['distribuidor_id'];
      $fecha_d = $this->request->data['Dato']['fecha'];
      $chips = $this->Chip->find('all', array(
        'recursive' => -1,
        'order' => 'Chip.id', 'limit' => $cantidad, 'fields' => array('Chip.id'),
        'conditions' => array('Chip.id >=' => $rango_ini, 'Chip.distribuidor_id' => $idDistribuidor, 'Chip.fecha_entrega_d' => $fecha_d)
      ));
      /* debug($chips);
        exit; */
      foreach ($chips as $ch) {
        $this->Chip->id = $ch['Chip']['id'];
        $dato['Chip']['fecha_entrega_d'] = date('Y-m-d');
        $dato['Chip']['distribuidor_id'] = NULL;
        $dato['Chip']['cliente_id'] = NULL;
        $this->Chip->save($dato['Chip']);
      }
      $this->Session->setFlash('Se cancela correctamente', 'msgbueno');
    } else {
      $this->Session->setFlash('No se pudo cancelar!!', 'msgerror');
    }
    $this->redirect($this->referer());
  }

  public function guardaexcelmigra() {

    $excelSubido = $nombreExcel;
    $objLector = new PHPExcel_Reader_Excel2007();
    //debug($objLector);die;
    $objPHPExcel = $objLector->load("../webroot/files/cliCrt.xlsx");
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
    $this->request->data = "";
    foreach ($array_data as $d) {
      $this->request->data[$i]['Cliente']['num_registro'] = $d['A'];
      $this->request->data[$i]['Cliente']['cod_dealer'] = $d['B'];
      $this->request->data[$i]['Cliente']['nombre'] = $d['C'];
      $this->request->data[$i]['Cliente']['direccion'] = $d['F'];
      $this->request->data[$i]['Cliente']['celular'] = $d['E'];
      $this->request->data[$i]['Cliente']['zona'] = $d['D'];
      $i++;
    }

    //debug($this->request->data);
    //exit;

    if ($this->Cliente->saveMany($this->data)) {
      //echo 'registro corectamente';
      //$this->Chip->deleteAll(array('Chip.sim' => '')); //limpiamos el excel con basuras
      $this->Session->setFlash('se Guardo correctamente el EXCEL', 'msgbueno');
      $this->redirect(array('controller' => 'Clientes', 'action' => 'index'));
    } else {
      echo 'no se pudo guardar';
    }
    //fin funciones del excel
  }

  public function verexcel($idExcel = null) {
    if ($this->RequestHandler->responseType() == 'json') {
      $this->paginate = array(
        'fields' => array('Chip.id', 'Chip.cantidad', 'Chip.tipo_sim', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.factura', 'Chip.fecha', 'Chip.caja'),
        'recursive' => 0,
        //'order' => 'Chip.created',
        'conditions' => array('Chip.excel_id' => $idExcel)
      );
      $this->DataTable->fields = array('Chip.id', 'Chip.cantidad', 'Chip.tipo_sim', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.factura', 'Chip.fecha', 'Chip.caja');
      $this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('chips', $this->DataTable->getResponse('Chips', 'Chip'));
      $this->set('_serialize', 'chips');
    }
    $cajas = array();
    for ($i = 1; $i <= 20; $i++) {
      $cajas["Caja $i"] = "Caja $i";
    }
    $this->set(compact('idExcel', 'cajas'));
  }

  public function registra_caja() {
    $tel_ini = $this->request->data['Dato']['tel_ini'];
    $tel_fin = $this->request->data['Dato']['tel_fin'];
    $caja = $this->request->data['Dato']['caja'];
    $factura_ini = $this->request->data['Dato']['ini_factura'];
    $condiciones = array();
    if (!empty($tel_fin)) {
      $idtel_ini = $this->get_id_tel($tel_ini);
      $idtel_fin = $this->get_id_tel($tel_fin);
      if ($idtel_ini == NULL) {
        $this->Session->setFlash("Verifique el telefono $tel_ini no existe!!", 'msgerror');
        $this->redirect($this->referer());
      }
      if ($idtel_fin == NULL) {
        $this->Session->setFlash("Verifique el telefono $tel_fin no existe!!", 'msgerror');
        $this->redirect($this->referer());
      }
      $condiciones['Chip.id >='] = $idtel_ini;
      $condiciones['Chip.id <='] = $idtel_fin;
    } else {
      $idtel_ini = $this->get_id_tel($tel_ini);
      if ($idtel_ini == NULL) {
        $this->Session->setFlash("Verifique el telefono $tel_ini no existe!!", 'msgerror');
        $this->redirect($this->referer());
      }
      $condiciones['Chip.id'] = $idtel_ini;
    }
    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => $condiciones,
      'fields' => array('Chip.id')
    ));
    $datoc['caja'] = $caja;
    foreach ($chips as $ch) {
      if (!empty($factura_ini)) {
        $datoc['factura'] = $factura_ini;
        $factura_ini++;
      }
      $this->Chip->id = $ch['Chip']['id'];
      $this->Chip->save($datoc);
    }
    $numero_c = count($chips);

    $this->Session->setFlash("Se asigno correctamente $numero_c chips", 'msgbueno');
    $this->redirect($this->referer());
  }

  //Devuelve el id del chip con el respectivo telefono
  public function get_id_tel($telefono = null) {
    $chip_b = $this->Chip->find('first', array(
      'recursive' => -1,
      'conditions' => array('Chip.telefono' => $telefono),
      'fields' => array('Chip.id')
    ));
    if (!empty($chip_b)) {
      return $chip_b['Chip']['id'];
    } else {
      return NULL;
    }
  }

  public function excel($fecha_entrega = null, $idDistribuidor = null) {
    $sql = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM personas WHERE personas.id = Distribuidor.persona_id";
    $sql2 = "SELECT lugares.nombre FROM lugares WHERE lugares.id = Distribuidor.lugare_id";
    $this->Chip->virtualFields = array(
      'nom_distribuidor' => "CONCAT(($sql))",
      'ciudad_dist' => "CONCAT(($sql2))"
    );
    $chips = $this->Chip->find('all', array(
      'recursive' => 0,
      'conditions' => array('Chip.distribuidor_id' => $idDistribuidor, 'Chip.fecha_entrega_d' => $fecha_entrega),
      'fields' => array('Chip.cantidad', 'Chip.sim', 'Chip.telefono', "DATE_FORMAT(Chip.fecha,'%m/%d/%Y') as fecha_f", "DATE_FORMAT(Chip.fecha_entrega_d,'%m/%d/%Y') as fecha_entrega_d_f", 'Distribuidor.persona_id'
        , 'Chip.nom_distribuidor', 'Distribuidor.lugare_id', 'Chip.ciudad_dist', 'Cliente.cod_dealer', 'Cliente.nombre', 'Cliente.cod_mercado')
    ));
    $this->set(compact('chips', 'fecha_entrega', 'idDistribuidor'));
  }

  public function genera_excel_1($fecha_entrega = null, $idDistribuidor = null) {

    $nombre_excel = "$fecha_entrega-$idDistribuidor.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');
    $borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        //,'color' => array('argb' => 'FFFF0000')
        )
      ),
      'font' => array(
        'size' => 12
        , 'bold' => true
      //,'color' => array('argb' => 'FFFF0000')
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FF7E00')
      )
    );
    $borders2 = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(11);

    $prueba->getActiveSheet()->getStyle('A1:L1')->applyFromArray($borders);
    $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "N");
    $prueba->setActiveSheetIndex(0)->setCellValue("B1", "CANTIDAD");
    $prueba->setActiveSheetIndex(0)->setCellValue("C1", "SIM");
    $prueba->setActiveSheetIndex(0)->setCellValue("D1", "NUM-TELEFONO");
    $prueba->setActiveSheetIndex(0)->setCellValue("E1", "FECHA");
    $prueba->setActiveSheetIndex(0)->setCellValue("F1", "Fecha de entrega");
    $prueba->setActiveSheetIndex(0)->setCellValue("G1", "COD.");
    $prueba->setActiveSheetIndex(0)->setCellValue("H1", "SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("I1", "COD.MERC");
    $prueba->setActiveSheetIndex(0)->setCellValue("J1", "DIST.");
    $prueba->setActiveSheetIndex(0)->setCellValue("K1", "CIUDAD");
    $prueba->setActiveSheetIndex(0)->setCellValue("L1", "FIRMA");

    $prueba->getActiveSheet()->setTitle("LISTADO de SIM'S ASIGNADOS");

    $sql = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM personas WHERE personas.id = Distribuidor.persona_id";
    $sql2 = "SELECT lugares.nombre FROM lugares WHERE lugares.id = Distribuidor.lugare_id";
    $this->Chip->virtualFields = array(
      'nom_distribuidor' => "CONCAT(($sql))",
      'ciudad_dist' => "CONCAT(($sql2))"
    );
    $chips = $this->Chip->find('all', array(
      'recursive' => 0,
      'conditions' => array('Chip.distribuidor_id' => $idDistribuidor, 'Chip.fecha_entrega_d' => $fecha_entrega),
      'fields' => array('Chip.cantidad', 'Chip.sim', 'Chip.telefono', "DATE_FORMAT(Chip.fecha,'%m/%d/%Y') as fecha_f", "DATE_FORMAT(Chip.fecha_entrega_d,'%m/%d/%Y') as fecha_entrega_d_f", 'Distribuidor.persona_id', 'Chip.nom_distribuidor', 'Distribuidor.lugare_id', 'Chip.ciudad_dist'),
      'order' => array('Chip.id')
    ));
    //debug($chips);exit;
    $cont = 1;
    $num = 0;
    foreach ($chips as $ch) {
      $cont++;
      $num++;
      $prueba->getActiveSheet()->getStyle("A$cont:L$cont")->applyFromArray($borders2);
      //$prueba->getActiveSheet()->getStyle("D$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
      $prueba->setActiveSheetIndex(0)->setCellValue("A" . $cont, $num);
      $prueba->setActiveSheetIndex(0)->setCellValue("B" . $cont, $ch['Chip']['cantidad']);
      $prueba->setActiveSheetIndex(0)->setCellValue("C" . $cont, $ch['Chip']['sim'] . " ");
      $prueba->setActiveSheetIndex(0)->setCellValue("D" . $cont, $ch['Chip']['telefono']);
      $prueba->setActiveSheetIndex(0)->setCellValue("E" . $cont, $ch[0]['fecha_f']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F" . $cont, $ch[0]['fecha_entrega_d_f']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("G" . $cont, $ch['Chip']['cantidad']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("H" . $cont, $ch['Chip']['cantidad']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("I" . $cont, $ch['Chip']['cantidad']);
      $prueba->setActiveSheetIndex(0)->setCellValue("J" . $cont, $ch['Chip']['nom_distribuidor']);
      $prueba->setActiveSheetIndex(0)->setCellValue("K" . $cont, $ch['Chip']['ciudad_dist']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("L" . $cont, $ch['Chip']['cantidad']);
    }
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function genera_excel_2($fecha_entrega = null, $idDistribuidor = null) {
    $nombre_excel = "$fecha_entrega-$idDistribuidor.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');
    $borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        //,'color' => array('argb' => 'FFFF0000')
        )
      ),
      'font' => array(
        'size' => 12
        , 'bold' => true
      //,'color' => array('argb' => 'FFFF0000')
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FF7E00')
      )
    );
    $borders2 = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(11);

    $prueba->getActiveSheet()->getStyle('A1:k1')->applyFromArray($borders);
    $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "CANTIDAD");
    $prueba->setActiveSheetIndex(0)->setCellValue("B1", "SIM");
    $prueba->setActiveSheetIndex(0)->setCellValue("C1", "NUM-TELEFONO");
    $prueba->setActiveSheetIndex(0)->setCellValue("D1", "FECHA");
    $prueba->setActiveSheetIndex(0)->setCellValue("E1", "Fecha de entrega");
    $prueba->setActiveSheetIndex(0)->setCellValue("F1", "COD.");
    $prueba->setActiveSheetIndex(0)->setCellValue("G1", "SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("H1", "COD.MERC");
    $prueba->setActiveSheetIndex(0)->setCellValue("I1", "DIST.");
    $prueba->setActiveSheetIndex(0)->setCellValue("J1", "CIUDAD");
    $prueba->setActiveSheetIndex(0)->setCellValue("K1", "FIRMA");

    $prueba->getActiveSheet()->setTitle("LISTADO de SIM'S ASIGNADOS");

    $sql = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM personas WHERE personas.id = Distribuidor.persona_id";
    $sql2 = "SELECT lugares.nombre FROM lugares WHERE lugares.id = Distribuidor.lugare_id";
    $this->Chip->virtualFields = array(
      'nom_distribuidor' => "CONCAT(($sql))",
      'ciudad_dist' => "CONCAT(($sql2))"
    );
    $chips = $this->Chip->find('all', array(
      'recursive' => 0,
      'conditions' => array('Chip.distribuidor_id' => $idDistribuidor, 'Chip.fecha_entrega_d' => $fecha_entrega, 'Chip.cliente_id <>' => NULL),
      'fields' => array('Chip.cantidad', 'Chip.sim', 'Chip.telefono', "DATE_FORMAT(Chip.fecha,'%m/%d/%Y') as fecha_f", "DATE_FORMAT(Chip.fecha_entrega_d,'%m/%d/%Y') as fecha_entrega_d_f",
        'Distribuidor.persona_id', 'Chip.nom_distribuidor', 'Distribuidor.lugare_id', 'Chip.ciudad_dist', 'Cliente.cod_dealer', 'Cliente.nombre', 'Cliente.cod_mercado')
    ));
    //debug($chips);exit;
    $cont = 1;
    foreach ($chips as $ch) {
      $cont++;
      $prueba->getActiveSheet()->getStyle("A$cont:k$cont")->applyFromArray($borders2);
      //$prueba->getActiveSheet()->getStyle("D$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
      $prueba->setActiveSheetIndex(0)->setCellValue("A" . $cont, $ch['Chip']['cantidad']);
      $prueba->setActiveSheetIndex(0)->setCellValue("B" . $cont, $ch['Chip']['sim'] . " ");
      $prueba->setActiveSheetIndex(0)->setCellValue("C" . $cont, $ch['Chip']['telefono']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D" . $cont, $ch[0]['fecha_f']);
      $prueba->setActiveSheetIndex(0)->setCellValue("E" . $cont, $ch[0]['fecha_entrega_d_f']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F" . $cont, $ch['Cliente']['cod_dealer']);
      $prueba->setActiveSheetIndex(0)->setCellValue("G" . $cont, $ch['Cliente']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("H" . $cont, $ch['Cliente']['cod_mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("I" . $cont, $ch['Chip']['nom_distribuidor']);
      $prueba->setActiveSheetIndex(0)->setCellValue("J" . $cont, $ch['Chip']['ciudad_dist']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("K" . $cont, $ch['Chip']['cantidad']);
    }
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function genera_excel_3($idExcel = null) {
    $nombre_excel = "asignados.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre_excel . '"');
    header('Cache-Control: max-age=0');
    $borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        //,'color' => array('argb' => 'FFFF0000')
        )
      ),
      'font' => array(
        'size' => 12
        , 'bold' => true
      //,'color' => array('argb' => 'FFFF0000')
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FF7E00')
      )
    );
    $borders3 = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        //,'color' => array('argb' => 'FFFF0000')
        )
      ),
      'font' => array(
        'size' => 12
        , 'bold' => true
      //,'color' => array('argb' => 'FFFF0000')
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '7dc35b')
      )
    );
    $borders2 = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $prueba = new PHPExcel();
    $prueba->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $prueba->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $prueba->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $prueba->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $prueba->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $prueba->getActiveSheet()->getColumnDimension('K')->setWidth(13);
    $prueba->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $prueba->getActiveSheet()->getColumnDimension('M')->setWidth(17);
    $prueba->getActiveSheet()->getColumnDimension('N')->setWidth(26);

    $prueba->getActiveSheet()->getStyle('A1:J1')->applyFromArray($borders);
    $prueba->getActiveSheet()->getStyle('K1:N1')->applyFromArray($borders3);
    $prueba->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

    $prueba->setActiveSheetIndex(0)->setCellValue("A1", "CANTIDAD");
    $prueba->setActiveSheetIndex(0)->setCellValue("B1", "SIM");
    $prueba->setActiveSheetIndex(0)->setCellValue("C1", "NUM-TELEFONO");
    $prueba->setActiveSheetIndex(0)->setCellValue("D1", "FECHA");
    $prueba->setActiveSheetIndex(0)->setCellValue("E1", "Fecha de entrega");
    $prueba->setActiveSheetIndex(0)->setCellValue("F1", "COD.");
    $prueba->setActiveSheetIndex(0)->setCellValue("G1", "SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("H1", "COD.MERC");
    $prueba->setActiveSheetIndex(0)->setCellValue("I1", "DIST.");
    $prueba->setActiveSheetIndex(0)->setCellValue("J1", "CIUDAD");
    $prueba->setActiveSheetIndex(0)->setCellValue("K1", "ACTIVACION");
    $prueba->setActiveSheetIndex(0)->setCellValue("L1", "C.DEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("M1", "C.SUBDEALER");
    $prueba->setActiveSheetIndex(0)->setCellValue("N1", "SUBDEALER");

    $prueba->getActiveSheet()->setTitle("LISTADO de SIM'S ASIGNADOS");

    $sql = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) FROM personas WHERE personas.id = Distribuidor.persona_id";
    $sql2 = "SELECT lugares.nombre FROM lugares WHERE lugares.id = Distribuidor.lugare_id";
    $this->Chip->virtualFields = array(
      'nom_distribuidor' => "CONCAT(($sql))",
      'ciudad_dist' => "CONCAT(($sql2))",
      'fecha_activacion' => "(SELECT activados.fecha_act FROM activados WHERE activados.phone_number = Chip.telefono LIMIT 1)",
      'ac_cod_dealer' => "(SELECT activados.dealer_code FROM activados WHERE activados.phone_number = Chip.telefono LIMIT 1)",
      'ac_cod_subdealer' => "(SELECT activados.subdealer_code FROM activados WHERE activados.phone_number = Chip.telefono LIMIT 1)",
      'ac_subdealer' => "(SELECT activados.subdealer FROM activados WHERE activados.phone_number = Chip.telefono LIMIT 1)"
    );
    $chips = $this->Chip->find('all', array(
      'recursive' => 0,
      'conditions' => array('Chip.excel_id' => $idExcel),
      'fields' => array('Chip.cantidad', 'Chip.sim', 'Chip.telefono', "DATE_FORMAT(Chip.fecha,'%m/%d/%Y') as fecha_f", "DATE_FORMAT(Chip.fecha_entrega_d,'%m/%d/%Y') as fecha_entrega_d_f",
        'Distribuidor.persona_id', 'Chip.nom_distribuidor', 'Distribuidor.lugare_id', 'Chip.ciudad_dist', 'Cliente.cod_dealer', 'Cliente.nombre', 'Cliente.cod_mercado', 'Chip.fecha_activacion', 'Chip.ac_cod_dealer', 'Chip.ac_cod_subdealer', 'Chip.ac_subdealer')
    ));
    //debug($chips);exit;
    $cont = 1;
    foreach ($chips as $ch) {
      $cont++;
      $prueba->getActiveSheet()->getStyle("A$cont:N$cont")->applyFromArray($borders2);
      //$prueba->getActiveSheet()->getStyle("D$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
      $prueba->setActiveSheetIndex(0)->setCellValue("A" . $cont, $ch['Chip']['cantidad']);
      $prueba->setActiveSheetIndex(0)->setCellValue("B" . $cont, $ch['Chip']['sim'] . " ");
      $prueba->setActiveSheetIndex(0)->setCellValue("C" . $cont, $ch['Chip']['telefono']);
      $prueba->setActiveSheetIndex(0)->setCellValue("D" . $cont, $ch[0]['fecha_f']);
      $prueba->setActiveSheetIndex(0)->setCellValue("E" . $cont, $ch[0]['fecha_entrega_d_f']);
      $prueba->setActiveSheetIndex(0)->setCellValue("F" . $cont, $ch['Cliente']['cod_dealer']);
      $prueba->setActiveSheetIndex(0)->setCellValue("G" . $cont, $ch['Cliente']['nombre']);
      $prueba->setActiveSheetIndex(0)->setCellValue("H" . $cont, $ch['Cliente']['cod_mercado']);
      $prueba->setActiveSheetIndex(0)->setCellValue("I" . $cont, $ch['Chip']['nom_distribuidor']);
      $prueba->setActiveSheetIndex(0)->setCellValue("J" . $cont, $ch['Chip']['ciudad_dist']);
      $prueba->setActiveSheetIndex(0)->setCellValue("K" . $cont, $ch['Chip']['fecha_activacion']);
      $prueba->setActiveSheetIndex(0)->setCellValue("L" . $cont, $ch['Chip']['ac_cod_dealer']);
      $prueba->setActiveSheetIndex(0)->setCellValue("M" . $cont, $ch['Chip']['ac_cod_subdealer']);
      $prueba->setActiveSheetIndex(0)->setCellValue("N" . $cont, $ch['Chip']['ac_subdealer']);
      //$prueba->setActiveSheetIndex(0)->setCellValue("K" . $cont, $ch['Chip']['cantidad']);
    }
    $objWriter = PHPExcel_IOFactory::createWriter($prueba, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function regulariza_excel_mercado() {
    //$excelSubido = $nombreExcel;
    $objLector = new PHPExcel_Reader_Excel2007();
    //debug($objLector);die;
    //debug("ssss");exit;
    //$objPHPExcel = PHPExcel_IOFactory::createReaderForFile("../webroot/files/mercados2.xlsx");
    $objPHPExcel = $objLector->load("../webroot/files/mercados2.xlsx");

    $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
    $array_data = array();

    foreach ($rowIterator as $row) {
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
      if ($row->getRowIndex() >= 2) { //a partir de la 1
        $rowIndex = $row->getRowIndex();
        $array_data[$rowIndex] = array(
          'J' => '',
          'N' => '');
        foreach ($cellIterator as $cell) {
          if ('J' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('N' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          }
        }
      }
    }
    /* debug('sss');
      debug($array_data);
      exit; */
    foreach ($array_data as $d) {
      $cliente = $this->Cliente->find('first', array(
        'recursive' => -1,
        'conditions' => array('Cliente.cod_dealer' => $d['J']),
        'fields' => array('Cliente.id')
      ));
      if (!empty($cliente)) {
        $this->Cliente->id = $cliente['Cliente']['id'];
        $mercado = explode("-", $d['N']);
        $datos_c['cod_mercado'] = $mercado[0];
        $datos_c['mercado'] = $d['N'];
        $this->Cliente->save($datos_c);
      }
    }
    debug('termino!!');
    exit;
  }

  public function todos() {

    if ($this->RequestHandler->responseType() == 'json') {
      $sql1 = "SELECT fecha_act FROM activados ac WHERE ac.phone_number = Chip.telefono";
      $ver = '<a href="javascript:void(0)" class="button blue-gradient glossy" onclick="infochip(' . "',Chip.id,'" . ')"><span class="icon-info"></span></a>';
      $this->Chip->virtualFields = array(
        'fecha_activacion' => "($sql1)",
        'ver' => "CONCAT('$ver')"
      );
      $this->paginate = array(
        'fields' => array('Chip.id', 'Chip.cantidad', 'Chip.telefono', 'Chip.factura', 'Chip.caja', 'Chip.fecha', 'Chip.sim', 'Chip.imsi', 'Chip.ver'),
        'recursive' => 0,
        'order' => 'Chip.created'
      );
      $this->DataTable->fields = array('Chip.id', 'Chip.cantidad', 'Chip.telefono', 'Chip.factura', 'Chip.caja', 'Chip.fecha', 'Chip.sim', 'Chip.imsi', 'Chip.ver');
      $this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('chips', $this->DataTable->getResponse());
      $this->set('_serialize', 'chips');
    }
  }

  public function info_chip($idChip = null) {
    $this->layout = 'ajax';

    $this->Chip->virtualFields = array(
      'distribuidor' => "(SELECT CONCAT(pe.nombre,' ',pe.ap_paterno,' ',pe.ap_materno) FROM personas pe WHERE Distribuidor.persona_id = pe.id)"
    );

    $chip = $this->Chip->find('first', array(
      'recursive' => 0,
      'conditions' => array('Chip.id' => $idChip)
    ));

    $activacion = $this->Activado->find('first', array(
      'recursive' => -1,
      'conditions' => array('Activado.phone_number' => $chip['Chip']['telefono'])
      , 'fields' => array('Activado.fecha_act')
    ));
    //debug($activacion);exit;

    $this->set(compact('chip', 'activacion'));
  }

  public function excel_asignados($idExcel = null) {
    $excel = $this->Excel->findByid($idExcel, null, null, -1);
    $sql = "SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) FROM personas p WHERE p.id = Distribuidor.persona_id";
    $this->Chip->virtualFields = array(
      'nombre_dist' => "CONCAT(($sql))"
    );
    $entregados = $this->Chip->find('all', array(
      'fields' => array('Chip.fecha_entrega_d', 'Chip.distribuidor_id', 'COUNT(*) as num_chips', 'Chip.nombre_dist', 'Chip.pagado', 'Chip.precio_d')
      , 'recursive' => 0
      , 'conditions' => array('Chip.distribuidor_id !=' => NULL, 'Chip.excel_id' => $idExcel)
      , 'group' => array('Chip.fecha_entrega_d', 'distribuidor_id')
      , 'order' => 'fecha_entrega_d DESC'
      , 'LIMIT' => 50
    ));
    //debug($entregados);exit;
    $precio_chip = $this->Precio->findByid(3);
    /* debug($precio_chip);exit; */
    $this->set(compact('entregados', 'excel', 'precio_chip'));
  }

  public function cambia_pagado($idExcel = null, $fecha = null, $idDistribuidor = null) {
    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array(
        'Chip.excel_id' => $idExcel,
        'Chip.fecha_entrega_d' => $fecha,
        'Chip.distribuidor_id' => $idDistribuidor
      ),
      'fields' => array('Chip.*')
    ));
    if (empty($chips)) {
      $this->redirect($this->referer());
    }
    $primer_chip = current($chips);
    $ultimo_chip = end($chips);
    $cantidad = count($chips);
    $precio = 0.00;
    $precio_c = $this->Precio->findByid(3, null, null, -1);
    if (!empty($primer_chip['Chip']['precio_d'])) {
      $precio = $primer_chip['Chip']['precio_d'];
    } elseif (!empty($precio_c['Precio']['monto'])) {
      $precio = $precio_c['Precio']['monto'];
    }
    $total_b = $cantidad * $precio;
    $literaltotal = $this->Montoliteral->getMontoLiteral($total_b);
    foreach ($chips as $ch) {
      $this->Chip->id = $ch['Chip']['id'];
      $dchip['pagado'] = 1;
      $this->Chip->save($dchip);
    }
    $distribuidor = $this->User->find('first', array(
      'recursive' => 0,
      'conditions' => array('User.id' => $idDistribuidor),
      'fields' => array('Persona.*')
    ));
    $this->set(compact('primer_chip', 'ultimo_chip', 'cantidad', 'precio', 'literaltotal', 'total_b', 'distribuidor'));
    //$this->Session->setFlash('Se registro el cambio!!','msgbueno');
    //$this->redirect($this->referer());
  }

  public function cambia_nopagado($idExcel = null, $fecha = null, $idDistribuidor = null) {
    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array(
        'Chip.excel_id' => $idExcel,
        'Chip.fecha_entrega_d' => $fecha,
        'Chip.distribuidor_id' => $idDistribuidor
      ),
      'fields' => array('Chip.id')
    ));
    foreach ($chips as $ch) {
      $this->Chip->id = $ch['Chip']['id'];
      $dchip['pagado'] = 0;
      $this->Chip->save($dchip);
    }
    $this->Session->setFlash('Se registro el cambio!!', 'msgbueno');
    $this->redirect($this->referer());
  }

  public function eliminar_ac($idExcel = null) {
    $this->Excel->delete($idExcel);
    $this->Activado->deleteAll(array('excel_id' => $idExcel));
    $this->Session->setFlash("Se elimino correctamente el excel!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function eliminar_as($idExcel = null) {
    $this->Excel->delete($idExcel);
    $this->Chip->deleteAll(array('Chip.excel_id' => $idExcel));
    $this->Session->setFlash("Se elimino correctamente el excel y sus registros!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function get_num_venciendo() {
    /* $chip_pr = $this->Chip->find('first',array(
      'recursive' => -1,
      'fields' => array('DATE_ADD(Chip.fecha, INTERVAL 60 DAY) as nueva_fecha')
      ));
      debug($chip_pr);exit; */

    $dia_actual = date('Y-m-d');
    $dia_20 = date('Y-m-d', strtotime($dia_actual . ' -20 day'));
    

    $sql3 = "(IF(EXISTS(SELECT id FROM activados ac WHERE ac.phone_number = Chip.telefono),1,0))";
    $this->Chip->virtualFields = array(
      'activado' => "CONCAT($sql3)"
    );
    

    $condiciones = array();
    $condiciones['DATE_ADD(Chip.fecha, INTERVAL 60 DAY) >='] = $dia_20;
    $condiciones['Chip.activado'] = 0;
    //debug($condiciones);exit;
    $datos = $this->Chip->find('all', array(
      'conditions' => $condiciones
    ));
    //debug($datos);exit;
    return $datos;
    //debug($datos);exit;
  }

  public function get_num_chips_dist($fecha_ini = null, $fecha_fin = null, $idDistribuidor = null) {
    $sql1 = "(SELECT SUM(ventaschips.cantidad) FROM ventaschips WHERE ventaschips.distribuidor_id = $idDistribuidor AND ventaschips.fecha <= '$fecha_fin')";
    $sql = "(SELECT COUNT(chips.id) FROM chips WHERE chips.distribuidor_id = $idDistribuidor AND chips.fecha_entrega_d >= '$fecha_ini' AND chips.fecha_entrega_d <= '$fecha_fin' GROUP BY chips.distribuidor_id)";
    $this->Chip->virtualFields = array(
      'ingresado' => "IF(ISNULL($sql),0,$sql)",
      'vendidos_t' => "IF(ISNULL($sql1),0,$sql1)"
    );
    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array('Chip.distribuidor_id' => $idDistribuidor, 'Chip.fecha_entrega_d <=' => $fecha_fin),
      'group' => array('Chip.distribuidor_id'),
      'fields' => array('COUNT(Chip.id) AS total_S', 'Chip.ingresado', 'Chip.vendidos_t')
    ));

    /* debug($chips);
      exit; */
    return $chips;
  }

  public function get_precios_ven() {
    $precios = $this->Precio->find('all', array(
      'recursive' => -1,
      'conditions' => array(
        'OR' => array(
          array('Precio.descripcion LIKE' => 'Chips'),
          array('Precio.descripcion LIKE' => 'Chip Distribuidor')
        )
      )
    ));

    return $precios;
  }

  public function get_num_vent_d($fecha_ini = null, $fecha_fin = null, $idDistribuidor = null, $precio = null) {
    $sql1 = "(SELECT IF(ISNULL(SUM(ventaschips.cantidad)),0,SUM(ventaschips.cantidad)) AS monto_total  FROM ventaschips WHERE ventaschips.distribuidor_id = $idDistribuidor AND ventaschips.fecha >= '$fecha_ini' AND ventaschips.fecha <= '$fecha_fin' AND ventaschips.precio = $precio)";
    $ven_t = $this->Ventaschip->query("$sql1");

    if (!empty($ven_t)) {
      return $ven_t[0][0]['monto_total'];
    } else {
      return 0;
    }
  }

  public function ajax_ventas_chips($fecha_ini = null, $fecha_fin = null, $idDistribuidor = null) {
    $precios = $this->Precio->find('all', array(
      'recursive' => -1,
      'conditions' => array(
        'OR' => array(
          array('Precio.descripcion LIKE' => 'Chips'),
          array('Precio.descripcion LIKE' => 'Chip Distribuidor')
        )
      )
    ));

    $ventas = $this->Ventaschip->find('all', array(
      'recurisive' => -1,
      'conditions' => array('Ventaschip.fecha' => $fecha_ini, 'Ventaschip.distribuidor_id' => $idDistribuidor)
    ));
    $this->set(compact('precios', 'idDistribuidor', 'fecha_ini', 'ventas'));
  }

  public function elimina_chip_dis($idVentaChip = null) {
    $this->Ventaschip->delete($idVentaChip);
    $this->Session->setFlash("Se ha eliminado correctamente la venta de chip!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function registra_ventachips() {
    $fecha_fin = $this->request->data['Dato']['fecha'];
    $idDistribuidor = $this->request->data['Dato']['distribuidor_id'];
    $cantidad_total = $this->request->data['Dato']['cantidad_total'];

    $sql1 = "(SELECT SUM(ventaschips.cantidad) FROM ventaschips WHERE ventaschips.distribuidor_id = $idDistribuidor AND ventaschips.fecha <= '$fecha_fin')";
    $this->Chip->virtualFields = array(
      'vendidos_t' => "IF(ISNULL($sql1),0,$sql1)"
    );

    $chips = $this->Chip->find('all', array(
      'recursive' => -1,
      'conditions' => array('Chip.distribuidor_id' => $idDistribuidor, 'Chip.fecha_entrega_d <=' => $fecha_fin),
      'group' => array('Chip.distribuidor_id'),
      'fields' => array('COUNT(Chip.id) AS total_S', 'Chip.vendidos_t')
    ));

    if (!empty($chips)) {
      $c_vendidos = $chips[0]['Chip']['vendidos_t'];
      $c_total_s = $chips[0][0]['total_S'];
      $total_actual = $c_total_s - $c_vendidos;
      if ($cantidad_total <= $total_actual) {
        foreach ($this->request->data['Ventaschip'] as $ven) {
          if (!empty($ven['cantidad'])) {
            $this->Ventaschip->create();
            $this->Ventaschip->save($ven);
          }
        }
        $this->Session->setFlash('Se ha registrado correctamente la venta', 'msgbueno');
      } else {
        $this->Session->setFlash('No hay suficiente para descontar!!', 'msgerror');
      }
    } else {
      $this->Session->setFlash('No hay suficiente para descontar!!', 'msgerror');
    }
    $this->redirect($this->referer());
  }

  public function get_estado_chips_exc($idExcel = null) {
    $sql = "(SELECT COUNT(chips.id) cantidad_total, COUNT(chips.distribuidor_id) distribuidor_total, COUNT(chips.cliente_id) asignados_total, COUNT(activados.id) activados_total FROM chips LEFT JOIN activados ON (activados.phone_number = chips.telefono) WHERE chips.excel_id = $idExcel)";
    $chips = $this->Chip->query($sql);
    if (!empty($chips)) {
      return 'D: ' . $chips[0][0]['distribuidor_total'] . ' SD: ' . $chips[0][0]['asignados_total'] . '| AC: ' . $chips[0][0]['activados_total'] . ' | T:' . $chips[0][0]['cantidad_total'];
    }
    //debug($chips);exit;
  }

  public function regulariza_chips_act($idExcel = null) {
    $sql = "(SELECT COUNT(activados.id) numero_total FROM activados LEFT JOIN chips ON (chips.telefono = activados.phone_number) WHERE activados.excel_id = $idExcel AND ISNULL(chips.id))";
    $n_chips = $this->Chip->find('count', array(
      'recursive' => -1,
      'conditions' => array('Chip.excel_id' => $idExcel)
    ));

    $numero = $this->Activado->query($sql);
    if (empty($numero)) {
      $array['numero'] = 0;
      $array['total'] = $n_chips;
    } else {
      $array['numero'] = $numero[0][0]['numero_total'];
      $array['total'] = $n_chips + $array['numero'];
    }
    //debug($array);exit;
    /* debug($numero[0][0]['numero_total']);
      exit; */
    $sql1 = "(SELECT activados.* FROM activados LEFT JOIN chips ON (chips.telefono = activados.phone_number) WHERE activados.excel_id = $idExcel AND ISNULL(chips.id) LIMIT 1)";
    $activado = $this->Activado->query($sql1);
    if (!empty($activado[0]['activados']['phone_number'])) {
      $d_chips['excel_id'] = $idExcel;
      $d_chips['factura'] = 0;
      $d_chips['cantidad'] = 0;
      $d_chips['sim'] = 0;
      $d_chips['telefono'] = $activado[0]['activados']['phone_number'];
      $d_chips['fecha'] = $activado[0]['activados']['fecha_doc'];
      $cliente = $this->Cliente->find('first', array(
        'recursive' => -1,
        'conditions' => array(
          'OR' => array(
            'Cliente.cod_dealer' => $activado[0]['activados']['subdealer_code'],
            'Cliente.num_registro' => $activado[0]['activados']['subdealer_code']
          )
        ),
        'fields' => array('Cliente.id')
      ));
      if (!empty($cliente['Cliente']['id'])) {
        $d_chips['cliente_id'] = $cliente['Cliente']['id'];
      }
      $this->Chip->create();
      $this->Chip->save($d_chips);
    }
    //debug($activado);exit;

    $this->respond($array, true);
  }

  public function asignados_imp($idDistribuidor = null) {
    if (!empty($idDistribuidor) && empty($this->request->data['Dato'])) {
      $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
      $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
      $this->request->data['Dato']['distribuidor_id'] = $idDistribuidor;
      $this->request->data['Dato']['tipo'] = '';
    }
    if (!empty($this->request->data['Dato'])) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $idDistribuidor = $this->request->data['Dato']['distribuidor_id'];
      $tipo = $this->request->data['Dato']['tipo'];
      $distribuidor = $this->User->find('first', array(
        'recursive' => 0,
        'conditions' => array('User.id' => $idDistribuidor)
      ));

      $condiciones = array();
      $condiciones['Chip.fecha_entrega_d >='] = $fecha_ini;
      $condiciones['Chip.fecha_entrega_d <='] = $fecha_fin;
      $condiciones['Chip.distribuidor_id'] = $idDistribuidor;
      //debug($tipo);exit;
      if ($tipo == 'VENDIDOS') {
        $condiciones['ISNULL( (SELECT ventasimpulsadores.id FROM ventasimpulsadores WHERE ventasimpulsadores.chip_id = Chip.id) )'] = '';
      } elseif ($tipo == 'NO VENDIDOS') {
        $condiciones['(SELECT ventasimpulsadores.id FROM ventasimpulsadores WHERE ventasimpulsadores.chip_id = Chip.id) IS NOT NULL'] = '';
      }
      $this->Chip->virtualFields = array(
        'cliente' => "(SELECT ventasimpulsadores.nombre_cliente FROM ventasimpulsadores WHERE ventasimpulsadores.chip_id = Chip.id)",
        'precio_chip' => "(SELECT ventasimpulsadores.precio_chip FROM ventasimpulsadores WHERE ventasimpulsadores.chip_id = Chip.id)",
        'regalo' => "(SELECT productos.nombre FROM ventasimpulsadores LEFT JOIN productos ON (ventasimpulsadores.producto_id = productos.id) WHERE ventasimpulsadores.chip_id = Chip.id)",
        'referencia' => "(SELECT ventasimpulsadores.tel_referencia FROM ventasimpulsadores WHERE ventasimpulsadores.chip_id = Chip.id)"
      );
      $chips = $this->Chip->find('all', array(
        'recursive' => -1,
        'conditions' => $condiciones
      ));
    }
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno)"
    );
    $distribuidores = $this->User->find('list', array(
      'recursive' => 0,
      'conditions' => array('User.group_id' => 7),
      'fields' => array('User.id', "nombre_completo", 'Group.name')
    ));
    $this->set(compact('distribuidores', 'chips', 'distribuidor'));
  }

}
