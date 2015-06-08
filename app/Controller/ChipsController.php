<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel_Reader_Excel2007', array('file' => 'PHPExcel/Excel2007.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel/PHPExcel/IOFactory.php'));

class ChipsController extends AppController {

  //public $helpers = array('Html', 'Form', 'Session', 'Js');
  public $uses = array('Chip', 'Excel', 'Chipstmp', 'User', 'Activado', 'Cliente');
  public $layout = 'viva';
  public $components = array('RequestHandler', 'DataTable');

  public function beforeFilter() {
    parent::beforeFilter();
    if ($this->RequestHandler->responseType() == 'json') {
      $this->RequestHandler->setContent('json', 'application/json');
    }
    //$this->Auth->allow();
  }

  public function subirexcel() {
    $excels = $this->Excel->find('all', array(
      'order' => array('Excel.id DESC'),
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
      $nombre = string::uuid();
      if (move_uploaded_file($archivoExcel['tmp_name'], WWW_ROOT . 'files' . DS . $nombre . '.xlsx')) {
        $nombreExcel = $nombre . '.xlsx';
        $direccionExcel = WWW_ROOT . 'files';
        $this->request->data['Excelg']['nombre'] = $nombreExcel;
        $this->request->data['Excelg']['nombre_original'] = $nombreOriginal;
        $this->request->data['Excelg']['direccion'] = "";
        $this->request->data['Excelg']['tipo'] = "activacion";
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

        if (1 == $row->getRowIndex()) //a partir de la 1
          continue; //skip first row

        $rowIndex = $row->getRowIndex();

        $array_data[$rowIndex] = array(
          'A' => '',
          'B' => '',
          'C' => '',
          'D' => '',
          'E' => '',
          'F' => '',
          'G' => '',
          'H' => '',
          'I' => '',
          'J' => '',
          'K' => '',
          'L' => '',
          'M' => '',
          'N' => '');

        foreach ($cellIterator as $cell) {

          if ('A' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('B' == $cell->getColumn()) {
            $fechaExcel = explode('/', $cell->getCalculatedValue());
            if (count($fechaExcel) > 1) {
              $array_data[$rowIndex][$cell->getColumn()] = $fechaExcel[2] . '-' . $fechaExcel[0] . '-' . $fechaExcel[1];
            } else {
              $array_data[$rowIndex][$cell->getColumn()] = date('Y-m-d', (($cell->getCalculatedValue() - 25568) * 86400));
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
              $array_data[$rowIndex][$cell->getColumn()] = $fechaExcel[2] . '-' . $fechaExcel[0] . '-' . $fechaExcel[1];
            } else {
              $array_data[$rowIndex][$cell->getColumn()] = date('Y-m-d', (($cell->getCalculatedValue() - 25568) * 86400));
            }
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
          } elseif ('I' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('J' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('K' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('L' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('M' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          } elseif ('N' == $cell->getColumn()) {
            $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
          }
        }
      }

      $datos = array();
      $this->request->data = "";
      $i = 0;
      foreach ($array_data as $d) {
        $this->request->data[$i]['Activado']['ciudad_nro_tel'] = $d['A'];
        $this->request->data[$i]['Activado']['fecha_act'] = $d['B'];
        $this->request->data[$i]['Activado']['fecha_doc'] = $d['C'];
        $this->request->data[$i]['Activado']['plan_code'] = $d['D'];
        $this->request->data[$i]['Activado']['description'] = $d['E'];
        $this->request->data[$i]['Activado']['phone_number'] = $d['F'];
        $this->request->data[$i]['Activado']['dealer_code'] = $d['G'];
        $this->request->data[$i]['Activado']['dealer'] = $d['H'];
        $this->request->data[$i]['Activado']['dealer_nom_act'] = $d['I'];
        $this->request->data[$i]['Activado']['subdealer_code'] = $d['J'];
        $this->request->data[$i]['Activado']['subdealer'] = $d['K'];
        $this->request->data[$i]['Activado']['subdealer_nom_act'] = $d['L'];
        $this->request->data[$i]['Activado']['canal_m'] = $d['M'];
        $this->request->data[$i]['Activado']['canal_n'] = $d['N'];
        $this->request->data[$i]['Activado']['excel_id'] = $ultimoExcel;
        $i++;
      }
      //debug($this->request->data);die;
      if (!empty($this->request->data[0]['Activado']['phone_number'])) {
        $verifica_tel = $this->Activado->find('first', array('conditions' => array('Activado.phone_number' => $this->request->data[0]['Activado']['phone_number'])));
        if (!empty($verifica_tel)) {
          $this->Session->setFlash("Ya se registro el excel verifique!!", 'msgerror');
          $this->redirect(array('action' => 'subirexcel'));
        }
      }

      if ($this->Activado->saveMany($this->data)) {
        $this->Session->setFlash('se Guardo correctamente el Excel', 'msgbueno');
        //debug($paraActivar);die;
        $this->redirect(array('action' => 'subirexcel'));
        //$verificaActivados = $this
      } else {
        echo 'no se pudo guardar';
      }
      //fin funciones del excel
    } else {

      //echo 'no';
    }
  }

  public function guardaexcel() {
    //debug($this->request->data);die;
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

        if ($row->getRowIndex() >= 3) { //a partir de la 1
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
            } elseif ('G' == $cell->getColumn()) {
              $fechaExcel = $cell->getCalculatedValue();
              $array_data[$rowIndex][$cell->getColumn()] = date('Y-m-d', (($fechaExcel - 25568) * 86400));
            }
          }
        }
      }
      $i = 0;
      $this->request->data = "";
      foreach ($array_data as $d) {
        $this->request->data[$i]['Chip']['excel_id'] = $ultimoExcel;
        $this->request->data[$i]['Chip']['cantidad'] = $d['A'];
        $this->request->data[$i]['Chip']['tipo_sim'] = $d['B'];
        $this->request->data[$i]['Chip']['sim'] = $d['C'];
        $this->request->data[$i]['Chip']['imsi'] = $d['D'];
        $this->request->data[$i]['Chip']['telefono'] = $d['E'];
        $this->request->data[$i]['Chip']['fecha'] = $d['G'];
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

      if ($this->Chip->saveMany($this->data)) {
        //echo 'registro corectamente';
        //$this->Chip->deleteAll(array('Chip.sim' => '')); //limpiamos el excel con basuras
        $this->Session->setFlash('se Guardo correctamente el EXCEL', 'msgbueno');
        $this->redirect(array('action' => 'subirexcel'));
      } else {
        echo 'no se pudo guardar';
      }
      //fin funciones del excel
    } else {

      //echo 'no';
    }
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
          //$array_data[$rowIndex][$cell->getColumn()] = PHPExcel_Style_NumberFormat::
          //toFormattedString($cell->getCalculatedValue(), 'YYYY-MM-DD');
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

  public function asigna_distrib() {
    $sql2 = "SELECT fecha_entrega_d FROM chips WHERE distribuidor_id = User.id ORDER BY fecha_entrega_d DESC LIMIT 1";
    $sql = "SELECT COUNT(*) FROM chips ch,activados ac WHERE ch.telefono = ac.phone_number AND ch.distribuidor_id = User.id AND ch.fecha_entrega_d = ($sql2)";
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno,' (',($sql),')')"
    );
    $distribuidores = $this->User->find('list', array('recursive' => 0, 'fields' => 'User.nombre_completo', array('Conditions' => array('User.group_id' => 2))));
    if ($this->RequestHandler->responseType() == 'json') {
      /* $editar = '<button class="button orange-gradient compact icon-pencil" type="button" onclick="editarc(' . "',Cliente.id,'" . ')">Editar</button>';
        $elimina = '<button class="button red-gradient compact icon-cross-round" type="button" onclick="eliminarc(' . "',Cliente.id,'" . ')">Eliminar</button>';
        $acciones = "$editar $elimina";
        $this->Chip->virtualFields = array(
        'acciones' => "CONCAT('$acciones')"
        ); */
      $this->paginate = array(
        'fields' => array('Chip.id', 'Chip.cantidad', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha', 'Excel.nombre_original'),
        'recursive' => 0,
        'order' => 'Chip.created'
        , 'conditions' => array('Chip.distribuidor_id' => NULL)
      );
      $this->DataTable->fields = array('Chip.id', 'Chip.cantidad', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha', 'Excel.nombre_original');
      $this->DataTable->emptyEleget_usuarios_adminments = 1;
      $this->set('chips', $this->DataTable->getResponse());
      $this->set('_serialize', 'chips');
    }
    $this->set(compact('distribuidores'));
  }

  public function registra_asignado() {
    if (!empty($this->request->data['Dato'])) {
      $rango_ini = $this->request->data['Dato']['rango_ini'];
      $cantidad = $this->request->data['Dato']['cantidad'];
      $chips = $this->Chip->find('all', array(
        'recursive' => -1,
        'order' => 'Chip.id', 'limit' => $cantidad, 'fields' => array('Chip.id'),
        'conditions' => array('Chip.id >=' => $rango_ini, 'Chip.distribuidor_id' => NULL)
      ));
      /* debug($chips);
        exit; */
      foreach ($chips as $ch) {
        $this->Chip->id = $ch['Chip']['id'];
        $dato['Chip']['fecha_entrega_d'] = date('Y-m-d');
        $dato['Chip']['distribuidor_id'] = $this->request->data['Dato']['distribuidor_id'];
        $this->Chip->save($dato['Chip']);
      }
      $this->Session->setFlash('Se asigno correctamente', 'msgbueno');
    } else {
      $this->Session->setFlash('No se pudo asignar!!', 'msgerror');
    }
    $this->redirect(array('action' => 'asigna_distrib'));
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

  public function detalle_entrega($fecha = null, $idDistribuidor = null) {
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
        $this->redirect(array('controller'=>'Clientes', 'action' => 'index'));
      } else {
        echo 'no se pudo guardar';
      }
      //fin funciones del excel
   
  }

}
