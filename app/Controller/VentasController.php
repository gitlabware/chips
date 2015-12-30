<?php

App::uses('AppController', 'Controller');

class VentasController extends AppController {

  public $uses = array('Ventasdistribuidore', 'Ventascliente', 'Ventasproducto', 'User', 'Cliente', 'Rutasusuario', 'Producto');
  public $layout = 'viva';

  public function distribuidores() {
    $distribuidores = $this->User->find('all', array(
      'recursive' => 0,
      'conditions' => array('User.group_id' => 2, 'User.estado' => 'Activo'),
      'fields' => array('Persona.nombre', 'Persona.ap_paterno', 'Persona.ap_materno', 'Persona.id', 'Persona.ci')
    ));
    $this->set(compact('distribuidores'));
  }

  public function registra_venta() {
    $idPersona = $this->request->data['Venta']['persona_id'];
    $fecha = $this->request->data['Venta']['fecha'];
    $venta = $this->Ventasdistribuidore->find('first', array(
      'recursive' => -1,
      'conditions' => array('Ventasdistribuidore.persona_id' => $idPersona, 'Ventasdistribuidore.fecha' => $fecha)
    ));
    //debug($venta);exit;
    if (!empty($venta)) {
      $dventa['id'] = $venta['Ventasdistribuidore']['id'];
    }
    $dventa['persona_id'] = $idPersona;
    $dventa['fecha'] = $fecha;
    $this->Ventasdistribuidore->create();
    $this->Ventasdistribuidore->save($dventa);
    if (!empty($venta)) {
      $idVenta = $venta['Ventasdistribuidore']['id'];
    } else {
      $idVenta = $this->Ventasdistribuidore->getLastInsertID();
    }
    $this->redirect(array('action' => 'clientes', $idVenta));
  }

  public function clientes($idVenta = null) {
    $venta = $this->Ventasdistribuidore->find('first', array(
      'recursive' => -1,
      'conditions' => array('Ventasdistribuidore.id' => $idVenta)
    ));
    $user = $this->User->findBypersona_id($venta['Ventasdistribuidore']['persona_id'], null, null, 0);
    $rutas = $this->Rutasusuario->find('list', array(
      'recursive' => -1,
      'conditions' => array('Rutasusuario.user_id' => $user['User']['id']),
      'fields' => array('Rutasusuario.ruta_id')
    ));
    $clientes = $this->Cliente->find('all', array(
      'recursive' => -1,
      'conditions' => array('Cliente.ruta_id' => $rutas)
    ));
    $this->set(compact('clientes', 'user', 'idVenta', 'venta'));
  }

  public function venta($idVenta = null, $idCliente = null) {
    $this->layout = 'ajax';

    $cliente = $this->Cliente->find('first', array(
      'recursive' => -1,
      'conditions' => array('Cliente.id' => $idCliente),
      'fields' => array('Cliente.nombre')
    ));
    $venta = $this->Ventasdistribuidore->findByid($idVenta);
    $estados = array(
      1 => 'Activo',
      2 => 'Fuera de servicio',
      3 => 'Cerrado'
    );
    $capacitacion = array(
      1 => 'SI',
      2 => 'NO'
    );

    $venta_c = $this->Ventascliente->find('first', array(
      'recursive' => -1,
      'conditions' => array('Ventascliente.ventasdistribuidore_id' => $idVenta, 'Ventascliente.cliente_id' => $idCliente)
    ));
    if (!empty($venta_c)) {
      $this->request->data['Ventascliente'] = $venta_c['Ventascliente'];
      $productos = $this->Ventasproducto->find('all', array(
        'recursive' => 0,
        'conditions' => array('Ventasproducto.ventasdistribuidore_id' => $idVenta),
        'fields' => array('Ventasproducto.*', 'Producto.id', 'Producto.nombre')
      ));
    } else {
      $productos = $this->Producto->find('all', array(
        'recursive' => -1,
        'fields' => array('Producto.id', 'Producto.nombre')
      ));
      $this->request->data['Ventascliente']['estado_pdv'] = 1;
      $this->request->data['Ventascliente']['cap'] = 2;
    }
    /* debug($this->request->data['Ventascliente']);
      exit; */
    $this->set(compact('venta', 'estados', 'capacitacion', 'idCliente', 'idVenta', 'productos', 'cliente'));
  }

  public function registra_venta_cli($idVenta = null) {
    $datos = $this->request->data;
    $this->Ventascliente->create();
    $this->Ventascliente->save($datos['Ventascliente']);
    foreach ($datos['Ventasproducto'] as $ve) {
      $this->Ventasproducto->create();
      $this->Ventasproducto->save($ve);
    }
    $this->Session->setFlash("Se registro correctamente la venta!!", 'msgbueno');
    $this->redirect(array('action' => 'clientes', $idVenta));
  }
  
  public function excel_ruteo_diario(){
    
  }

}
