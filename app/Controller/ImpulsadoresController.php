<?php

App::uses('AppController', 'Controller');

class ImpulsadoresController extends AppController {

  var $uses = array('User', 'Minievento', 'Ventasimpulsadore', 'Premio', 'Movimientospremio','Precio');
  public $layout = 'viva';

  public function minievento($idMini = null) {
    $this->layout = 'ajax';
    $this->Minievento->id = $idMini;
    $this->request->data = $this->Minievento->read();
  }

  public function minieventos() {

    $minieventos = $this->Minievento->find('all', array(
      'recursive' => -1,
      'conditions' => array('Minievento.impulsador_id' => $this->Session->read('Auth.User.id')),
      'order' => array('Minievento.id DESC')
    ));
    $this->set(compact('minieventos'));
  }

  public function registra_minievento() {
    if (!empty($this->request->data['Minievento'])) {
      $this->Minievento->create();
      $this->Minievento->save($this->request->data['Minievento']);
      $this->Session->setFlash("Se registro correctamente el minievento", 'msgbueno');
    } else {
      $this->Session->setFlash("No se pudo registrar el minievento", 'msgerror');
    }
    $this->redirect(array('action' => 'minieventos'));
  }

  public function ventas_minievento($idMini = null) {
    $minievento = $this->Minievento->findByid($idMini, null, null, -1);
    $ventas = $this->Ventasimpulsadore->find('all', array(
      'conditions' => array('Ventasimpulsadore.minievento_id' => $idMini),
      'recursive' => -1
    ));
    $this->Premio->virtualFields = array(
      'nombre_total' => "CONCAT(Premio.nombre,' (',Premio.total,')')"
    );
    $premios = $this->Premio->find('list',array('fields' => 'Premio.nombre_total','conditions' => array('Premio.total >' => 0))); 
    $precios = $this->Precio->find('list',array('fields' => array('Precio.monto','Precio.monto')));
    //debug($minievento);exit;
    $this->set(compact('minievento', 'ventas','premios','precios'));
  }

  public function registra_venta() {
    
    if(!empty($this->request->data['Ventasimpulsadore']['premio_id'])){
      $premio = $this->Premio->findByid($this->request->data['Ventasimpulsadore']['premio_id'],null,null,-1);
      if($premio['Premio']['total'] >= 1){
        $this->Premio->id = $premio['Premio']['id'];
        $dpre['total'] = $premio['Premio']['total']-1;
        $this->Premio->save($dpre);
        $this->Movimientospremio->create();
        $dmov['premio_id'] = $premio['Premio']['id'];
        $dmov['user_id'] = $this->Session->read('Auth.User.id');
        $dmov['salida'] = 1;
        $dmov['persona_id'] = $this->Session->read('Auth.User.persona_id');
        $this->Movimientospremio->save($dmov);
      }else{
        $this->Session->setFlash("No se pudo registrar no hay premio!!",'msgerror');
        $this->redirect($this->referer());
      }
    }
    $this->Ventasimpulsadore->create();
    $this->Ventasimpulsadore->save($this->request->data['Ventasimpulsadore']);
    $this->Session->setFlash("Se registro correctamente la venta!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function quita_venta($idVenta = null) {
    $venta = $this->Ventasimpulsadore->findByid($idVenta,null,null,-1);
    if(!empty($venta['Ventasimpulsadore']['premio_id'])){
      $premio = $this->Premio->findByid($venta['Ventasimpulsadore']['premio_id']);
      $this->Premio->id = $premio['Premio']['id'];
      $dpre['total'] = $premio['Premio']['total'] + 1;
      $this->Premio->save($dpre);
      $this->Movimientospremio->create();
      $dmov['premio_id'] = $premio['Premio']['id'];
      $dmov['user_id'] = $this->Session->read('Auth.User.id');
      $dmov['persona_id'] = $this->Session->read('Auth.User.persona_id');
      $dmov['ingreso'] = 1;
      $this->Movimientospremio->save($dmov);
    }
    $this->Ventasimpulsadore->delete($idVenta);
    $this->Session->setFlash("Se elimino correctamente la venta!!", 'msgbueno');
    $this->redirect($this->referer());
  }

  public function premios() {
    $premios = $this->Premio->find('all');
    $this->set(compact('premios'));
  }

  public function registra_n_premio() {
    $this->Premio->create();
    $this->Premio->save($this->request->data['Premio']);
    $idPremio = $this->Premio->getLastInsertID();
    $this->Movimientospremio->create();
    $datm['premio_id'] = $idPremio;
    $datm['ingreso'] = $this->request->data['Premio']['total'];
    $datm['user_id'] = $this->Session->read('Auth.User.id');
    $this->Movimientospremio->save($datm);
    $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
    $this->redirect(array('action' => 'premios'));
  }

  public function movimientospremios($idPremio = null) {
    $premio = $this->Premio->findByid($idPremio);
    $movimientos = $this->Movimientospremio->find('all',array(
      'recursive' => 0,
      'conditions' => array('Movimientospremio.premio_id' => $idPremio,'Movimientospremio.user_id' => $this->Session->read('Auth.User.id')),
      'fields' => array('Movimientospremio.created','Movimientospremio.ingreso','Movimientospremio.id'),
      'order' => array('Movimientospremio.id DESC')
    ));
    $this->set(compact('premio','movimientos'));
  }
  public function registra_entrega_pre(){
    $this->Movimientospremio->create();
    $this->Movimientospremio->save($this->request->data['Movimientospremio']);
    $premio = $this->Premio->findByid($this->request->data['Movimientospremio']['premio_id']);
    $this->Premio->id = $premio['Premio']['id'];
    $datp['total'] = $premio['Premio']['total'] + $this->request->data['Movimientospremio']['ingreso'];
    $this->Premio->save($datp);
    $this->Session->setFlash("Se registro correctamente!!",'msgbueno');
    $this->redirect($this->referer());
  }
  public function cancela_ent_pre($idMov = null){
    $movimiento = $this->Movimientospremio->findByid($idMov,null,null,-1);
    $premio = $this->Premio->findByid($movimiento['Movimientospremio']['premio_id'],null,null,-1);
    if($premio['Premio']['total'] >= $movimiento['Movimientospremio']['ingreso']){
      $this->Premio->id = $premio['Premio']['id'];
      $dmov['total'] = $premio['Premio']['total'] - $movimiento['Movimientospremio']['ingreso'];
      $this->Premio->save($dmov);
      $this->Movimientospremio->delete($idMov);
      $this->Session->setFlash("Se cancelo correctamente la entrega!!",'msgbueno');
    }else{
      $this->Session->setFlash("No se pudo tegistrar debido a que el total es inferior al monto!!",'msgerror');
    }
    $this->redirect($this->referer());
  }

}
