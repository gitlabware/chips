<?php

class MarcasController extends AppController {

  public $uses = array(
    'Marca',
  );
  public $layout = 'viva';
  
  public function index(){
    $marcas = $this->Marca->find('all');
    $this->set(compact('marcas'));
  }
  public function marca($idMarca = null){
    $this->layout = 'ajax';
    $this->Marca->id = $idMarca;
    if(!empty($this->request->data['Marca'])){
      $this->Marca->create();
      $this->Marca->save($this->request->data['Marca']);
      $this->Session->setFlash("Se ha registrado correctamente!!",'msgbueno');
      $this->redirect(array('action' => 'index'));
    }
    $this->request->data = $this->Marca->read();
  }
  
  public function eliminar($idMarca = null){
    $this->Marca->delete($idMarca);
    $this->Session->setFlash("Se ha eliminado correctamente!!",'msgerror');
    $this->redirect($this->referer());
  }

}
