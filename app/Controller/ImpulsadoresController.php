<?php

App::uses('AppController', 'Controller');

class ImpulsadoresController extends AppController{
  var $uses = array('User','Minievento','Ventasimpulsadore');
  public $layout = 'viva';
  
  
  public function minievento($idMini = null){
    $this->layout = 'ajax';
    $this->Minievento->id = $idMini;
    $this->request->data = $this->Minievento->read();
  }
  public function minieventos(){
    
    $minieventos = $this->Minievento->find('all',array(
      'recursive' => -1,
      'conditions' => array('Minievento.impulsador_id' => $this->Session->read('Auth.User.id')),
      'order' => array('Minievento.id DESC')
    ));
    $this->set(compact('minieventos'));
  }
  public function registra_minievento(){
    if(!empty($this->request->data['Minievento'])){
      $this->Minievento->create();
      $this->Minievento->save($this->request->data['Minievento']);
      $this->Session->setFlash("Se registro correctamente el minievento",'msgbueno');
    }else{
      $this->Session->setFlash("No se pudo registrar el minievento",'msgerror');
    }
    $this->redirect(array('action' => 'minieventos'));
  }
  public function ventas_minievento($idMini = null){
    $minievento = $this->Minievento->findByid($idMini,null,null,-1);
    $ventas = $this->Ventasimpulsadore->find('all',array(
      'conditions' => array('Ventasimpulsadore.minievento_id' => $idMini),
      'recursive' => -1
    ));
    //debug($minievento);exit;
    $this->set(compact('minievento','ventas'));
  }
  
  public function registra_venta(){
    $this->Ventasimpulsadore->create();
    $this->Ventasimpulsadore->save($this->request->data['Ventasimpulsadore']);
    $this->Session->setFlash("Se registro correctamente la venta!!",'msgbueno');
    $this->redirect($this->referer());
  }
  public function quita_venta($idVenta = null){
    $this->Ventasimpulsadore->delete($idVenta);
    $this->Session->setFlash("Se elimino correctamente la venta!!",'msgbueno');
    $this->redirect($this->referer());
  }
  
}