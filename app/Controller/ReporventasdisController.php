<?php
class ReporventasdisController extends AppController {
    public $helpers = array('Html',
        'Form',
        'Js');
    public $uses = array('Producto',
        'Persona',
        'Movimiento',
        'Ruteosupervisore',
        'Recarga',
        'Detalleobservacione',
        'Ventasdistribuidore',
        'Productosprecio',
        'Ruteo',
        'Ruta',
        'Cliente',
        'Tiposobservacione',
        
        'Listacliente');
    
    public $layout = 'viva';
    public $components = array('RequestHandler', 'Session');

    public function beforeFilter()
    {
        parent::beforeFilter();
        //$this->Auth->allow();
    }
    
    function index() {
        $id = $this->Session->read('Auth.User.persona_id');
        $fecha = date("Y-m-d");
        $dia = $this->getday();

        //debug($ruta);exit;
        
        $lista = $this->Cliente->find('all', array('conditions' => array('Cliente.ruta_id' => $id_ruta)));

        //debug($lista);exit;
        //$ventas = $this->Ventaa->find('all', array("conditions" => array("Ventaa.fecha" => $fecha, "Ventaa.usuario_id" => $id)));
        //debug($ventas);exit;
        //$estado = 0;
        $i = 0;
        $cmp = array();


        $this->set(compact('lista', 'cmp', 'ruta'));
    }
    
    function nombredist() {
                $personas = $this->Persona->find('all', array(
                'conditions'=>array( 'User.group_id'=>'2')));     
                $this->set(compact('personas'));
                //debug($personas); exit;
            if (!empty($this->request->data)){
            $id = $this->request->data['Persona']['id'];
            $persona = $this->Persona->find('first', array(
                'conditions' => array(
                    'Persona.id' => $id
            )));
            if (!empty($persona)) {
                $idPerso = $persona['Persona']['id'];
                $this->redirect(array('action' => 'reporte', $idPerso));
            } else {
                $this->Session->setFlash('No existe el cliente con codigo de registro: ' . $codigo .
                        ', consulte al administrador del sistema');
                $this->redirect(array('action' => 'nombredist'), null, true);
            }
        }
                        
         }
 function reporte($id = null) {
     debug($id);exit;
        //$this->layout= 'ajax';
 }
    
 
 
 }


?>
