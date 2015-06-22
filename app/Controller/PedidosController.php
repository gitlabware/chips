<?php

class PedidosController extends AppController {

  public $layout = 'viva';
  public $uses = array('Pedido', 'Productosprecio', 'User');

  function beforeFilter() {
    parent::beforeFilter();
    //$this->Auth->allow();
  }

  public function index() {
    $sql = "SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) FROM personas p WHERE p.id = Distribuidor.persona_id";
    $this->Pedido->virtualFields = array(
      'nombre_dist' => "CONCAT(($sql))"
    );
    $pedidos = $this->Pedido->find('all', array(
      'group' => array('Pedido.numero'),
      'limit' => 50,
      'order' => 'Pedido.numero DESC'
    ));
    $this->set(compact('pedidos'));
  }

  public function pedido($numero = null) {
    $productos = $this->Productosprecio->find('all', array(
      'fields' => array('Producto.nombre', 'Producto.id'),
      'conditions' => array('Productosprecio.tipousuario_id' => 3, 'Productosprecio.escala' => 'MAYOR'),
      'group' => array('Productosprecio.producto_id')
    ));
    $pedidos_c = $this->Pedido->find('list', array('fields' => array('Pedido.producto_id', 'Pedido.cantidad'), 'conditions' => array('Pedido.numero' => $numero)));
    $pedidos_i = $this->Pedido->find('list', array('fields' => array('Pedido.producto_id', 'Pedido.id'), 'conditions' => array('Pedido.numero' => $numero)));
    $ultimo_pedido = $this->Pedido->find('first', array('conditions' => array('Pedido.numero' => $numero), 'order' => 'Pedido.id DESC'));
    if (!empty($ultimo_pedido)) {
      $this->request->data['Dato']['monto'] = $ultimo_pedido['Pedido']['monto'];
      $this->request->data['Dato']['numero'] = $ultimo_pedido['Pedido']['numero'];
      $this->request->data['Dato']['distribuidor_id'] = $ultimo_pedido['Pedido']['distribuidor_id'];
    }
    $this->User->virtualFields = array(
      'nombre_person' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $distribuidores = $this->User->find('list', array('recursive' => 0, 'fields' => array('User.nombre_person'), 'conditions' => array('User.group_id' => 2)));
    /* debug($pedidos_i);
      exit; */
    $this->set(compact('productos', 'pedidos_c', 'pedidos_i', 'ultimo_pedido', 'distribuidores'));
  }

  public function registra_pedido() {
    $ult_pedido = $this->Pedido->find('first', array('order' => 'Pedido.id DESC'));
    if (empty($this->request->data['Dato']['numero'])) {
      if (!empty($ult_pedido)) {
        $numero = $ult_pedido['Pedido']['numero'] + 1;
      } else {
        $numero = 1;
      }
    } else {
      $numero = $this->request->data['Dato']['numero'];
    }
    $monto = $this->request->data['Dato']['monto'];
    foreach ($this->request->data['Pedido'] as $pe) {
      if ($pe['cantidad'] != '') {
        $dape['id'] = $pe['id'];
        $dape['user_id'] = $this->Session->read('Auth.User.id');
        $dape['producto_id'] = $pe['producto_id'];
        $dape['cantidad'] = $pe['cantidad'];
        $dape['numero'] = $numero;
        $dape['monto'] = $monto;
        $dape['distribuidor_id'] = $this->request->data['Dato']['distribuidor_id'];
        $this->Pedido->create();
        $this->Pedido->save($dape);
      }
    }
    $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
    $this->redirect(array('action' => 'index'));
  }
  
  public function eliminar_pedido($NumPedido = null) {
    $this->Pedido->deleteAll(array('Pedido.numero' => $NumPedido));
    $this->Session->setFlash("Se elimino correctamente el pedido!!", 'msgbueno');
    $this->redirect($this->referer());
  }
  
}

?>