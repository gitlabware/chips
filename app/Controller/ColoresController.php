<?php

class ColoresController extends AppController {

  public $uses = array(
    'Colore',
  );
  public $layout = 'viva';
  
  public function index(){
    $colores = $this->Colore->find('all');
    $this->set(compact('colores'));
  }
  public function color($idColore = null){
    $this->layout = 'ajax';
    $this->Colore->id = $idColore;
    if(!empty($this->request->data['Colore'])){
      $this->Colore->create();
      $this->Colore->save($this->request->data['Colore']);
      $this->Session->setFlash("Se ha registrado correctamente!!",'msgbueno');
      $this->redirect(array('action' => 'index'));
    }
    $this->request->data = $this->Colore->read();
  }
  
  public function eliminar($idColore = null){
    $this->Colore->delete($idColore);
    $this->Session->setFlash("Se ha eliminado correctamente!!",'msgerror');
    $this->redirect($this->referer());
  }

}
