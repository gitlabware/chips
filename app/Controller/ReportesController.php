
<?php

class ReportesController extends Controller {

  public $uses = array(
    'Movimiento',
    'Almacene',
    'Ventasdistribuidore',
    'Persona',
    'Producto',
    'User',
    'Productosprecio',
    'Recarga',
    'Chip',
    'Deposito',
    'Sucursal',
    'Cliente', 'Ventascelulare', 'Pago', 'Tiposproducto', 'Cajachica', 'Totale', 'Meta');
  public $layout = 'viva';
  public $components = array('Fechasconvert', 'Session');

  public function beforeFilter() {
    parent::beforeFilter();
    // $this->Auth->allow('*');
  }

  public function reporte($fecha = null) {
    //$fecha1= $this->Fechasconvert->doFecha($fecha);
    $fecha1 = date('Y-m-d');

    $idAlmacenCentral = $this->Almacene->find('first', array(
      'conditions' => array('Almacene.central' => true)));

    $idAlmacenCentral = $idAlmacenCentral['Almacene']['id'];

    $ingresosAlmacen1 = $this->Movimiento->find('all', array(
      'fields' => array('sum(Movimiento.ingreso) as ingreso', 'Producto.id', 'Producto.nombre'),
      'conditions' => array(
        'Movimiento.almacene_id' => $idAlmacenCentral,
        'Movimiento.created' => $fecha1,
        'Movimiento.salida' => '0'),
      'group' => array('Movimiento.producto_id'),
      'order' => array('Movimiento.producto_id')
    ));

    $stockAlmacen = $this->Movimiento->find('all', array(
      'fields' => array('MAX(Movimiento.id) as id'),
      'conditions' => array(
        'Movimiento.almacene_id' => $idAlmacenCentral,
        'Movimiento.created' => $fecha1,
        'Movimiento.ingreso' => '0'),
      'group' => array('Movimiento.producto_id')
    ));

    $ides1 = array();
    $i = 0;
    foreach ($stockAlmacen as $ide) {
      $ides1[$i++] = $ide[0]['id'];
    }
    $stockAlmacen = $this->Movimiento->find('all', array(
      'fields' => array('Producto.id', 'Movimiento.saldo', 'Producto.nombre'),
      'conditions' => array(
        'Movimiento.id' => $ides1),
      'order' => array('Movimiento.producto_id')
    ));

    $i = 0;

    foreach ($ingresosAlmacen1 as $ingreso) {
      foreach ($stockAlmacen as $stock) {

        if ($stock['Producto']['id'] == $ingreso['Producto']['id']) {
          $ingresosAlmacen[$i]['0']['ingreso'] = $ingreso['0']['ingreso'];
          $ingresosAlmacen[$i]['Producto']['id'] = $ingreso['Producto']['id'];
          $ingresosAlmacen[$i]['Producto']['nombre'] = $ingreso['Producto']['nombre'];
          $ingresosAlmacen[$i]['Movimiento']['saldo'] = $stock['Movimiento']['saldo'];
          $i++;
        } else {
          $ingresosAlmacen[$i]['Movimiento']['saldo'] = $stock['Movimiento']['saldo'];
          $ingresosAlmacen[$i]['0']['ingreso'] = 0;
          $ingresosAlmacen[$i]['Producto']['id'] = $stock['Producto']['id'];
          $ingresosAlmacen[$i]['Producto']['nombre'] = $stock['Producto']['nombre'];
          $i++;
        }
      }
    }
    //debug($ingresosAlmacen);exit;
    $distribuidores = $this->Movimiento->find('all', array(
      'fields' => array('MAX(Movimiento.id) as id'),
      'conditions' => array('Movimiento.salida' => 0),
      'group' => array('Movimiento.persona_id', 'Movimiento.producto_id')));


    $ides = array();
    $i = 0;
    foreach ($distribuidores as $distribuidor) {
      $ides[$i++] = $distribuidor[0]['id'];
    }

    $entregas = $this->Movimiento->find('all', array(
      'conditions' => array('Movimiento.id' => $ides, 'Movimiento.created' => $fecha1),
      'fields' => array(
        'Movimiento.almacene_id', 'Movimiento.persona_id',
        'Movimiento.saldo', 'Movimiento.ingreso', 'Producto.nombre', 'Producto.id',
        'Almacene.nombre', 'Almacene.central', 'Persona.nombre', 'Persona.ap_paterno',
        'Persona.ap_materno', 'Movimiento.id', 'Producto.tiposproducto_id'),
      'order' => array('Movimiento.persona_id', 'Movimiento.almacene_id')
    ));
    //debug($entregas);exit;
    $this->set(compact('ingresosAlmacen', 'entregas', 'idAlmacenCentral'));
  }

  public function ventas() {
    $today = date('Y-m-d');
    //$today = '2013-04-16';
    $ventashoy = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array('Ventasdistribuidore.fecha' => $today),
      'recursive' => 0
      )
    );
    //debug($ventashoy);exit;
    $this->set(compact('ventashoy'));
  }

  public function form() {
    if (!empty($this->request->data)) {
      //debug($this->request->data);exit;   
      $distirbuidor = $this->request->data['Persona']['id'];
      $fecha = $this->Fechasconvert->doFormatdia($this->request->data['Persona']['fecha']);
      $datos = $this->User->find('first', array('conditions' => array('User.id' => $distirbuidor)));
      $user = $datos['User']['id'];
      $this->redirect(array('action' => 'reportedistribuidor2', $distirbuidor, $fecha));
    }
    $distribuidores = $this->User->find('all', array(
      'conditions' => array('User.group_id' => '2')
    ));
    $this->set(compact('distribuidores'));
  }

  public function form2() {
    if (!empty($this->request->data)) {
      //debug($this->request->data);exit;
      $fecha1 = $this->Fechasconvert->doFormatdia($this->request->data['Persona']['fecha1']);
      $fecha2 = $this->Fechasconvert->doFormatdia($this->request->data['Persona']['fecha2']);
      if (!empty($this->request->data['Persona']['id'])) {
        $distirbuidor = $this->request->data['Persona']['id'];

        $datos = $this->User->find('first', array('conditions' => array('Persona.id' => $distirbuidor)));
        $user = $datos['User']['id'];
        $this->redirect(array('action' => 'ventasdistribuidor', $distirbuidor, $user, $fecha1, $fecha2));
      } else {
        $cliente = $this->request->data['Persona']['cliente'];

        $datos = $this->Cliente->find('first', array('conditions' => array('Cliente.num_registro' => $cliente)));

        $user = $datos['Cliente']['id'];
        $this->redirect(array('action' => 'ventasclientes', $user, $fecha1, $fecha2));
      }
    }
    $distribuidores = $this->User->find('all', array(
      'conditions' => array('User.group_id' => '2')
    ));
    $this->set(compact('distribuidores'));
  }

  public function ventasdistribuidor($persona = null, $usuario_id = null, $desde = null, $hasta = null) {
    $this->layout = 'imprimetabla';
    $datos = $this->Persona->find('first', array(
      'conditions' => array('Persona.id' => $persona),
      'recursive' => -1));
    $distribuidor = $datos['Persona']['nombre'] . ' ' . $datos['Persona']['ap_paterno'];
    $ventas = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array(
        'Ventasdistribuidore.fecha >=' => $desde,
        'Ventasdistribuidore.fecha <=' => $hasta,
        'Ventasdistribuidore.user_id' => $usuario_id),
      'fields' => array('Producto.nombre', 'sum(Ventasdistribuidore.cantidad) as cantidad', 'sum(Ventasdistribuidore.total) as total'),
      'order' => array('Ventasdistribuidore.cliente_id ASC', 'Ventasdistribuidore.producto_id ASC', 'Ventasdistribuidore.precio DESC'),
      'group' => array('Ventasdistribuidore.producto_id')));
    //debug($ventas);
    $this->set(compact('ventas', 'distribuidor', 'desde', 'hasta'));
  }

  public function ventasclientes($cliente = null, $desde = null, $hasta = null) {

    $this->layout = 'imprimetabla';
    $datos = $this->Cliente->find('first', array(
      'conditions' => array('Cliente.id' => $cliente),
      'recursive' => -1));

    $ventas = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array(
        'Ventasdistribuidore.fecha >=' => $desde,
        'Ventasdistribuidore.fecha <=' => $hasta,
        'Ventasdistribuidore.cliente_id' => $cliente),
      'fields' => array('Producto.nombre', 'sum(Ventasdistribuidore.cantidad) as cantidad', 'sum(Ventasdistribuidore.total) as total'),
      'order' => array('Ventasdistribuidore.cliente_id ASC', 'Ventasdistribuidore.producto_id ASC', 'Ventasdistribuidore.precio DESC'),
      'group' => array('Ventasdistribuidore.producto_id')));
    $this->set(compact('ventas', 'datos', 'desde', 'hasta'));
  }

  public function reportedistribuidor($persona = null, $usuario_id = null, $hoy = null) {

    //debug($hoy);exit;
    $this->layout = "imprimetabla";


    $datos = $this->Persona->find('first', array(
      'conditions' => array('Persona.id' => $persona),
      'recursive' => -1));
    $distribuidor = $datos['Persona']['nombre'] . ' ' . $datos['Persona']['ap_paterno'];

    $dia = $hoy;
    $precios = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'order' => array('Producto.id ASC', 'Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
        'Productosprecio.escala')));

    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));
    //debug($rows);
    // debug($precios); 
//debug($hoy);exit;
    $ventas = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array(
        'Ventasdistribuidore.fecha >=' => $desde,
        'Ventasdistribuidore.fecha <=' => $hasta,
        'Ventasdistribuidore.user_id' => $usuario_id),
      'fields' => array('Producto.nombre', 'sum(Ventasdistribuidore.cantidad) as cantidad', 'sum(Ventasdistribuidore.total) as total'),
      'order' => array('Ventasdistribuidore.cliente_id ASC', 'Ventasdistribuidore.producto_id ASC', 'Ventasdistribuidore.precio DESC'),
      'group' => array('Ventasdistribuidore.producto_id')));

    $clientes = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array('Ventasdistribuidore.fecha' => $hoy, 'Ventasdistribuidore.user_id' => $usuario_id),
      'group' => array('Ventasdistribuidore.cliente_id'),
      'order' => array('Ventasdistribuidore.cliente_id ASC')
    ));
    //debug($clientes);exit;
    //$sql = "SELECT * FROM recargas WHERE recargas.created like '$hoy' AND recargas.user_id = '$usuario_id'";
    //debug($sql);exit;

    $recargas = $this->Recarga->find('all', array(
      'conditions' => array(
        'Recarga.created' => $hoy,
        'Recarga.user_id' => $usuario_id)));
    //debug($recargas);exit; 
    //if (empty($ventas)) {
    /* $ruta = $this->Ruteo->find('first', array('conditions' => array('Ruteo.dia' => $dia, 'Ruteo.distribuidor_id' => $usuario_id),
      'fields' => array('Ruteo.id')
      )); */
    //debug($ruta);exit;
    /* $clientes = $this->Listacliente->find('all', array('conditions' => array('Listacliente.ruteo_id' =>
      $ruta['Ruteo']['id'], 'Listacliente.distribuidor_id' => $usuario_id),
      'group' => array('Listacliente.cliente_id')
      )); */
    //debug($clientes);exit;
    // $ides = array();
    //$i = 0;
    /* foreach ($clientes as $id) {
      $ides[$i] = $id['Listacliente']['cliente_id'];
      $i++;
      } */
    //debug($ides);exit;
    /* $obs = $this->Detalleobservacione->find('all', array('conditions' => array('Detalleobservacione.fecha_registro' =>
      $hoy, 'Detalleobservacione.cliente_id' => $ides))); */

    //debug($obs);exit;
    //}
    $deposito = $this->Deposito->find('first', array(
      'conditions' => array('Deposito.created' => $hoy, 'Deposito.persona_id' => $persona)
    ));
    //debug($deposito);exit;
    $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'distribuidor', 'usuario_id', 'deposito'));
  }

  public function reportedistribuidor2($persona = null, $hoy = null) {
    $this->layout = "imprimetabla";
    $usuario = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.persona_id' => $persona)));
    //$usuario_id = $this->Session->read('Auth.User.id');
    $usuario_id = $usuario['User']['id'];
    $per = $this->Persona->find('first', array('recursive' => -1, 'conditions' => array('Persona.id' => $persona)));

    $distribuidor = $per['Persona']['nombre'];
    //$persona =$this->Session->read('Auth.User.Persona.id');
    //$hoy = date('Y-m-d');
    $dia = $hoy;
    $precios = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'order' => array('Producto.id ASC', 'Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
        'Productosprecio.escala')));

    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));
    //debug($rows);
    // debug($precios);
//debug($hoy);exit;
    $ventas = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array('Ventasdistribuidore.fecha' => $hoy, 'Ventasdistribuidore.user_id' => $usuario_id),
      'order' => array('Ventasdistribuidore.cliente_id ASC', 'Ventasdistribuidore.producto_id ASC', 'Ventasdistribuidore.precio DESC')));
    //debug($ventas);
    $clientes = $this->Ventasdistribuidore->find('all', array(
      'conditions' => array('Ventasdistribuidore.fecha' => $hoy, 'Ventasdistribuidore.user_id' => $usuario_id),
      'group' => array('Ventasdistribuidore.cliente_id'),
      'order' => array('Ventasdistribuidore.cliente_id ASC')
    ));
    //debug($clientes);exit;
    $sql = "SELECT * FROM recargas WHERE recargas.created like '$hoy' AND recargas.user_id = '$usuario_id'";
    //debug($sql);exit;

    $recargas = $this->Recarga->find('all', array(
      'conditions' => array(
        'Recarga.created' => $hoy,
        'Recarga.user_id' => $usuario_id)));
    $deposito = $this->Deposito->find('first', array(
      'conditions' => array('Deposito.created' => $hoy, 'Deposito.persona_id' => $persona)
    ));
    $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'distribuidor', 'deposito', 'usuario_id'));
  }

  public function saldos($idDistribuidor = null) {

    if (!empty($this->request->data)) {
      //debug($this->request->data);exit;
      $fecha = $this->request->data['Persona']['fecha'];
      $date = $this->Fechasconvert->doFormatdia($fecha);

      $user = $this->request->data['Persona']['id'];

      $dato = $this->User->find('first', array(
        'conditions' => array('User.id' => $user)));
      $distribuidor = $dato['User']['persona_id'];

      $this->redirect(array('action' => 'reportesaldos', $user, $distribuidor, $date));
    }
    $personas = $this->User->find('all', array('conditions' => array('User.group_id' => 2)));
    $this->set(compact('personas'));
  }

  public function reportesaldos($idUser = null, $idDistribuidor = null, $fecha = null) {
    $this->layout = "imprimetabla";
    $dato = $this->Persona->find('first', array('conditions' => array('Persona.id' => $idDistribuidor)));
    $nombre = $dato['Persona']['nombre'] . ' ' . $dato['Persona']['ap_paterno'];
    $precios = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'order' => array('Producto.id ASC', 'Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
        'Productosprecio.escala')));

    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));

    $recargas = $this->Recarga->find('all', array(
      'conditions' => array('Recarga.persona_id' => $idDistribuidor, 'Recarga.created' => $fecha)
    ));


    $this->set(compact('nombre', 'rows', 'precios', 'idDistribuidor', 'fecha', 'recargas'));
  }

  public function saldoshorizontal($idUser = null, $fecha = null) {

    $distribuidor = $this->User->find('first', array('conditions' => array('User.id' => $idUser)));
    $idDistribuidor = $distribuidor['User']['persona_id'];
    $this->layout = "imprimetabla";
    $dato = $this->Persona->find('first', array('conditions' => array('Persona.id' => $idDistribuidor)));
    $nombre = $dato['Persona']['nombre'] . ' ' . $dato['Persona']['ap_paterno'];


    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));

    $fech = $fecha . '%';
    $recargas = $this->Recarga->find('all', array(
      'conditions' => array('Recarga.persona_id' => $idDistribuidor, 'Recarga.created like' => $fech)
    ));

    $hora = $this->Ventasdistribuidore->find('first', array('conditions' => array(
        'Ventasdistribuidore.persona_id' => $idDistribuidor, 'Ventasdistribuidore.fecha' => $fecha)
    ));

    if (empty($hora)) {
      $hora = $this->Fechasconvert->getHora($hora[0]['Recarga']['created']);
    } else
      $hora = $this->Fechasconvert->getHora($hora['Ventasdistribuidore']['created']);

    $deposito = $this->Deposito->find('first', array(
      'conditions' => array('Deposito.created' => $fecha, 'Deposito.persona_id' => $idDistribuidor)
    ));

    $this->set(compact('nombre', 'hora', 'fecha', 'rows', 'precios', 'idDistribuidor', 'recargas', 'deposito'));
  }

  public function saldoshorizontal_mobile($idUser = null, $fecha = null) {

    $distribuidor = $this->User->find('first', array('conditions' => array('User.id' => $idUser)));
    $idDistribuidor = $distribuidor['User']['persona_id'];
    $this->layout = "vivadistribuidor_mobile";
    $dato = $this->Persona->find('first', array('conditions' => array('Persona.id' => $idDistribuidor)));
    $nombre = $dato['Persona']['nombre'] . ' ' . $dato['Persona']['ap_paterno'];


    $rows = $this->Productosprecio->find('all', array(
      'conditions' => array(
        'Productosprecio.tipousuario_id' => 3,
        'Producto.proveedor like' => 'VIVA',
        'Producto.estado' => '1'),
      'fields' => array(
        'Count(Productosprecio.id) as cantidad',
        'Producto.nombre',
        'Producto.id'),
      'group' => array('Productosprecio.producto_id')));

    $fech = $fecha . '%';
    $recargas = $this->Recarga->find('all', array(
      'conditions' => array('Recarga.persona_id' => $idDistribuidor, 'Recarga.created like' => $fech)
    ));

    $hora = $this->Ventasdistribuidore->find('first', array('conditions' => array(
        'Ventasdistribuidore.persona_id' => $idDistribuidor, 'Ventasdistribuidore.fecha' => $fecha)
    ));

    if (empty($hora)) {
      $hora = $this->Fechasconvert->getHora($hora[0]['Recarga']['created']);
    } else
      $hora = $this->Fechasconvert->getHora($hora['Ventasdistribuidore']['created']);

    $deposito = $this->Deposito->find('first', array(
      'conditions' => array('Deposito.created' => $fecha, 'Deposito.persona_id' => $idDistribuidor)
    ));

    $this->set(compact('nombre', 'hora', 'fecha', 'rows', 'precios', 'idDistribuidor', 'recargas', 'deposito'));
  }

  public function detalletienda() {
    if (!empty($this->request->data)) {
      $sucursal = $this->request->data['Tienda']['sucursal_id'];
      $fecha = $this->request->data['Tienda']['fecha'];
      $this->redirect(array('controller' => 'Tiendas', 'action' => 'reporteventastienda', $sucursal, $fecha));
    }
    $sucursales = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('sucursales'));
  }

  public function xmayortienda() {
    if (!empty($this->request->data)) {
      $sucursal = $this->request->data['Tienda']['sucursal_id'];
      $fecha = $this->request->data['Tienda']['fecha'];
      $this->redirect(array('controller' => 'Tiendas', 'action' => 'reporte149', $sucursal, $fecha));
    }
    $sucursales = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('sucursales'));
  }

  public function reporte_chips() {
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      //debug($this->request->data['Dato']);exit;
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $sql1 = "(SELECT users.persona_id FROM users WHERE (users.id = Chip.distribuidor_id))";
      $sql11 = "(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas WHERE (personas.id = ($sql1)))";
      $sql2 = "(SELECT COUNT(*) FROM chips c,activados a WHERE c.telefono = a.phone_number AND Chip.distribuidor_id = c.distribuidor_id)";
      $this->Chip->virtualFields = array(
        'distribuidor' => "CONCAT($sql11)",
        'activados' => "CONCAT($sql2)"
      );
      $datos = $this->Chip->find('all', array(
        'recursive' => 0,
        'conditions' => array('Chip.fecha_entrega_d >=' => $fecha_ini, 'Chip.fecha_entrega_d <=' => $fecha_fin),
        'group' => array('Chip.distribuidor_id'),
        'fields' => array('Chip.distribuidor', 'Chip.activados', 'COUNT(*) entregados', 'Chip.distribuidor_id')
      ));

      /* debug($datos);
        exit; */
    }
    $this->set(compact('datos'));
  }

  public function reporte_chips_clientes() {
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $activado_t = $this->request->data['Dato']['activado'];
      $idDistribuidor = $this->request->data['Dato']['distribuidor_id'];
      $sql1 = "(SELECT users.persona_id FROM users WHERE (users.id = Chip.distribuidor_id))";
      $sql11 = "(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas WHERE (personas.id = ($sql1)))";
      $sql2 = "(SELECT nombre FROM lugares WHERE lugares.id = (SELECT users.lugare_id FROM users WHERE (users.id = Chip.distribuidor_id)))";
      $sql3 = "(IF(EXISTS(SELECT id FROM activados ac WHERE ac.phone_number = Chip.telefono),1,0))";
      $this->Chip->virtualFields = array(
        'distribuidor' => "CONCAT($sql11)",
        'lugar_dis' => "CONCAT($sql2)",
        'activado' => "CONCAT($sql3)"
      );
      $condiciones = array();
      $condiciones['Chip.fecha >='] = $fecha_ini;
      $condiciones['Chip.fecha <='] = $fecha_fin;
      $condiciones['Chip.activado'] = $activado_t;
      $condiciones['Chip.distribuidor_id'] = $idDistribuidor;
      //debug($condiciones);exit;
      $datos = $this->Chip->find('all', array(
        'conditions' => $condiciones
      ));
    }
    $this->User->virtualFields = array(
      'nombre_d' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $distribuidores = $this->User->find('list', array('fields' => 'User.nombre_d', 'recursive' => 0, 'conditions' => array('User.group_id' => 2)));
    $this->set(compact('datos', 'distribuidores'));
  }

  public function reporte_chips_c_total() {
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $activado_t = $this->request->data['Dato']['activado'];
      $idDistribuidor = $this->request->data['Dato']['distribuidor_id'];
      $sql1 = "(SELECT users.persona_id FROM users WHERE (users.id = Chip.distribuidor_id))";
      $sql11 = "(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas WHERE (personas.id = ($sql1)))";
      $sql2 = "(SELECT nombre FROM lugares WHERE lugares.id = (SELECT users.lugare_id FROM users WHERE (users.id = Chip.distribuidor_id)))";
      $sql3 = "(SELECT COUNT(*) FROM chips c,activados a WHERE c.telefono = a.phone_number AND Chip.distribuidor_id = c.distribuidor_id AND c.distribuidor_id = $idDistribuidor)";
      $this->Chip->virtualFields = array(
        'distribuidor' => "CONCAT($sql11)",
        'lugar_dis' => "CONCAT($sql2)",
        'activados' => "CONCAT($sql3)"
      );
      $condiciones = array();
      $condiciones['Chip.fecha >='] = $fecha_ini;
      $condiciones['Chip.fecha <='] = $fecha_fin;
      $condiciones['Chip.distribuidor_id'] = $idDistribuidor;
      //debug($condiciones);exit;
      $datos = $this->Chip->find('all', array(
        'conditions' => $condiciones
        , 'group' => array('Chip.cliente_id'),
        'fields' => array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.zona', 'Chip.distribuidor', 'Chip.lugar_dis', 'Chip.activados', 'COUNT(*) as total')
      ));
    }
    $this->User->virtualFields = array(
      'nombre_d' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $distribuidores = $this->User->find('list', array('fields' => 'User.nombre_d', 'recursive' => 0, 'conditions' => array('User.group_id' => 2)));
    $this->set(compact('datos', 'distribuidores'));
  }

  public function reporte_cliente_tienda() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $sucursal = $this->request->data['Dato']['sucursal_id'];
    $almacen = $this->Almacene->find('first', array(
      'recursives' => -1,
      'conditions' => array('Almacene.sucursal_id' => $sucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $almacen['Almacene']['id'];
    $condiciones1 = array();
    if (!empty($sucursal)) {
      $condiciones1['Movimiento.almacene_id'] = $idAlmacen;
    } else {
      $condiciones1['Movimiento.almacene_id !='] = NULL;
    }
    if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
      $condiciones1['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
    }
    if (!empty($this->request->data['Dato']['producto_id'])) {
      $condiciones1['Producto.id'] = $this->request->data['Dato']['producto_id'];
    }
    //$condiciones1['Movimiento.sucursal_id !='] = NULL;
    $condiciones1['Movimiento.cliente_id !='] = NULL;
    $condiciones1['Movimiento.created >='] = $fecha_ini;
    $condiciones1['Movimiento.created <='] = $fecha_fin;
    //debug($condiciones1);exit;
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $sql2 = "(SELECT su.nombre FROM sucursals su WHERE su.id = Almacene.sucursal_id)";
      $this->Movimiento->virtualFields = array(
        'nombre_sucursal' => "CONCAT($sql2)"
      );
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones1,
        'group' => array('Movimiento.cliente_id', 'Almacene.sucursal_id'),
        'fields' => array('Cliente.nombre', 'Cliente.num_registro', 'Movimiento.cliente_id', 'SUM(Movimiento.salida) ventas', 'SUM(Movimiento.precio_uni*Movimiento.salida)', 'Movimiento.nombre_sucursal', 'Movimiento.almacene_id', 'Almacene.sucursal_id')
      ));
      //debug($datos);exit;
      foreach ($datos as $key => $da) {
        $datos_aux = $this->Movimiento->find('all', array(
          'recursive' => 0, 'order' => 'Movimiento.producto_id',
          'conditions' => array('Movimiento.almacene_id' => $da['Movimiento']['almacene_id'], 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.cliente_id' => $da['Movimiento']['cliente_id'], 'Movimiento.salida !=' => 'null'),
          'group' => array('Movimiento.producto_id', 'Movimiento.precio_uni'),
          'fields' => array('Producto.nombre', 'SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total')
        ));
        $datos[$key]['productos'] = $datos_aux;
      }
      //debug($datos);exit;
    }
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $sucursales = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('datos', 'sucursales', 'categorias'));
  }

  public function reporte_detallado_precio_tienda() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $sucursal = $this->request->data['Dato']['sucursal_id'];
    $almacen = $this->Almacene->find('first', array(
      'recursives' => -1,
      'conditions' => array('Almacene.sucursal_id' => $sucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $almacen['Almacene']['id'];
    //debug($idAlmacen);exit;
    $condiciones1 = array();
    $alamacen_sql = '';
    $alamacen_sql2 = '';
    if (!empty($sucursal)) {
      $condiciones1['Movimiento.almacene_id'] = $idAlmacen;
      $alamacen_sql = "mo.almacene_id = $idAlmacen AND";
      $alamacen_sql2 = "mov.almacene_id = $idAlmacen AND";
    }
    if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
      $condiciones1['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
    }
    if (!empty($this->request->data['Dato']['producto_id'])) {
      $condiciones1['Producto.id'] = $this->request->data['Dato']['producto_id'];
    }
    //$condiciones1['Movimiento.sucursal_id !='] = NULL;
    //$condiciones1['Movimiento.sucursal_id !='] = 1;
    $condiciones1['Movimiento.salida !='] = NULL;
    $condiciones1['Movimiento.created >='] = $fecha_ini;
    $condiciones1['Movimiento.created <='] = $fecha_fin;
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE $alamacen_sql Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE $alamacen_sql2 mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $sql3 = "(SELECT su.nombre FROM sucursals su WHERE su.id = Almacene.sucursal_id)";
      //$sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM movimientos mo WHERE $sucursal_sql mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND Producto.id = mo.producto_id ORDER BY mo.id DESC LIMIT 1)";
      $this->Movimiento->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))",
        'nombre_sucursal' => "CONCAT($sql3)"
      );
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones1,
        'group' => array('Movimiento.producto_id', 'Movimiento.sucursal_id'),
        'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.total_s', 'Movimiento.sucursal_id', 'Sucursal.nombre', 'Movimiento.nombre_sucursal', 'Movimiento.almacene_id')
      ));
      foreach ($datos as $key => $da) {
        $datos_aux = $this->Movimiento->find('all', array(
          'recursive' => -1, 'order' => 'Movimiento.producto_id',
          'conditions' => array('Movimiento.almacene_id' => $da['Movimiento']['almacene_id'], 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.producto_id' => $da['Producto']['id']),
          'group' => array('Movimiento.precio_uni'),
          'fields' => array('SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total', 'Movimiento.producto_id')
        ));
        $datos[$key]['precios'] = $datos_aux;
        //debug($datos);exit;
      }
    }
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $sucursales = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('datos', 'sucursales', 'categorias'));
  }

  public function reportes_tienda() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $sucursal = $this->request->data['Dato']['sucursal_id'];
    $almacen = $this->Almacene->find('first', array(
      'recursives' => -1,
      'conditions' => array('Almacene.sucursal_id' => $sucursal),
      'fields' => array('Almacene.id')
    ));
    $idAlmacen = $almacen['Almacene']['id'];
    $condiciones1 = array();
    $sucursal_sql = '';
    $sucursal_sql2 = '';
    $alamacen_sql = '';
    /* debug($this->request->data);
      exit; */
    if (!empty($sucursal)) {
      $condiciones1['Movimiento.almacene_id'] = $idAlmacen;
      $sucursal_sql = "mo.almacene_id = $idAlmacen AND";
      $sucursal_sql2 = "mov.almacene_id = $idAlmacen AND";
      $alamacen_sql = "mo.almacene_id = $idAlmacen AND";
    }
    if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
      $condiciones1['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
    }
    if (!empty($this->request->data['Dato']['producto_id'])) {
      $condiciones1['Producto.id'] = $this->request->data['Dato']['producto_id'];
    }
    //$condiciones1['Movimiento.sucursal_id !='] = NULL;
    $condiciones1['Movimiento.salida !='] = NULL;
    $condiciones1['Movimiento.created >='] = $fecha_ini;
    $condiciones1['Movimiento.created <='] = $fecha_fin;

    if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
      
    }
    $datos = array();
    /* debug($fecha_ini);
      debug($fecha_fin);exit; */
    if (!empty($this->request->data['Dato'])) {
      $sql1 = "(SELECT IF(ISNULL(SUM(mo.salida)),0,SUM(mo.salida)) FROM movimientos mo WHERE $sucursal_sql mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'TIENDA' AND Producto.id = mo.producto_id)";
      $sql2 = "(SELECT IF(ISNULL(SUM(mo.salida)),0,SUM(mo.salida)) FROM movimientos mo WHERE $sucursal_sql mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'MAYOR' AND Producto.id = mo.producto_id)";
      $sql3 = "(SELECT IF(ISNULL(SUM(mo.precio_uni*mo.salida)),0,SUM(mo.precio_uni*mo.salida)) FROM movimientos mo WHERE $sucursal_sql mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'TIENDA' AND Producto.id = mo.producto_id)";
      $sql4 = "(SELECT IF(ISNULL(SUM(mo.precio_uni*mo.salida)),0,SUM(mo.precio_uni*mo.salida)) FROM movimientos mo WHERE $sucursal_sql mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'MAYOR' AND Producto.id = mo.producto_id)";

      $sql6 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE $alamacen_sql Producto.id = mo.producto_id LIMIT 1)";
      $sql5 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE $sucursal_sql2 mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $sql7 = "(SELECT su.nombre FROM sucursals su WHERE su.id = Almacene.sucursal_id)";
      //$sql5 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM movimientos mo WHERE $sucursal_sql mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND Producto.id = mo.producto_id ORDER BY mo.id DESC LIMIT 1)";
      $this->Movimiento->virtualFields = array(
        'ventas' => "CONCAT($sql1)",
        'ventas_mayor' => "CONCAT($sql2)",
        'precio_v_t' => "CONCAT($sql3)",
        'precio_v_mayor' => "CONCAT($sql4)",
        'total_s' => "CONCAT($sql6-(IF(ISNULL($sql5),0,$sql5)))",
        'nombre_sucursal' => "CONCAT($sql7)"
      );
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones1,
        'group' => array('Movimiento.producto_id', 'Movimiento.sucursal_id'),
        'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.ventas', 'Movimiento.ventas_mayor', 'Movimiento.precio_v_t', 'Movimiento.precio_v_mayor', 'Movimiento.total_s', 'Almacene.sucursal_id', 'Movimiento.nombre_sucursal')
      ));
      /* debug($datos);
        exit; */
    }
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $sucursales = $this->Sucursal->find('list', array('fields' => 'Sucursal.nombre'));
    $this->set(compact('datos', 'sucursales', 'categorias'));
  }

  public function ajax_l_productos($idTipoprod = null) {
    $this->layout = 'ajax';
    /* debug($idTipoprod);
      exit; */
    $productos = $this->Producto->find('list', array('fields' => 'nombre', 'conditions' => array('Producto.tiposproducto_id' => $idTipoprod)));
    $this->set(compact('productos'));
  }

  public function reporte_detallado_precio_dist() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $persona = $this->request->data['Dato']['persona_id'];
    $condiciones1 = array();
    $persona_sql = '';
    $persona_sql2 = '';
    if (!empty($persona)) {
      $condiciones1['Movimiento.persona_id'] = $persona;
      $persona_sql = "mo.persona_id = $persona AND";
      $persona_sql2 = "mov.persona_id = $persona AND";
    }
    if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
      $condiciones1['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
    }
    if (!empty($this->request->data['Dato']['producto_id'])) {
      $condiciones1['Producto.id'] = $this->request->data['Dato']['producto_id'];
    }
    $condiciones1['Movimiento.persona_id !='] = NULL;
    $condiciones1['Movimiento.salida !='] = NULL;
    $condiciones1['Movimiento.created >='] = $fecha_ini;
    $condiciones1['Movimiento.created <='] = $fecha_fin;
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE $persona_sql Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE $persona_sql2 mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";

      $this->Movimiento->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
      );
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones1,
        'group' => array('Movimiento.producto_id'),
        'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.total_s', 'Persona.nombre', 'Persona.ap_paterno')
      ));
      foreach ($datos as $key => $da) {
        $datos_aux = $this->Movimiento->find('all', array(
          'recursive' => -1, 'order' => 'Movimiento.producto_id',
          'conditions' => array('Movimiento.persona_id' => $persona, 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.producto_id' => $da['Producto']['id'], 'Movimiento.salida !=' => NULL),
          'group' => array('Movimiento.precio_uni'),
          'fields' => array('SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total', 'Movimiento.producto_id')
        ));
        $datos[$key]['precios'] = $datos_aux;
        //debug($datos);exit;
      }
    }
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $distribuidores = $this->User->find('list', array('recursive' => 0, 'conditions' => array('User.group_id' => 2), 'fields' => array('User.persona_id', 'User.nombre_completo')));
    $this->set(compact('datos', 'distribuidores', 'categorias'));
  }

  public function reporte_cliente_dist() {
    $fecha_ini = $this->request->data['Dato']['fecha_ini'];
    $fecha_fin = $this->request->data['Dato']['fecha_fin'];
    $persona = $this->request->data['Dato']['persona_id'];
    $condiciones1 = array();
    if (!empty($persona)) {
      $condiciones1['Movimiento.persona_id'] = $persona;
    }
    if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
      $condiciones1['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
    }
    if (!empty($this->request->data['Dato']['producto_id'])) {
      $condiciones1['Producto.id'] = $this->request->data['Dato']['producto_id'];
    }
    $condiciones1['Movimiento.persona_id !='] = NULL;
    $condiciones1['Movimiento.salida !='] = NULL;
    $condiciones1['Movimiento.cliente_id !='] = NULL;
    $condiciones1['Movimiento.created >='] = $fecha_ini;
    $condiciones1['Movimiento.created <='] = $fecha_fin;
    $datos = array();
    if (!empty($this->request->data['Dato'])) {
      $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones1,
        'group' => array('Movimiento.cliente_id'),
        'fields' => array('Cliente.nombre', 'Cliente.num_registro', 'Movimiento.cliente_id', 'SUM(Movimiento.salida) ventas', 'SUM(Movimiento.precio_uni*Movimiento.salida)', 'Persona.nombre', 'Persona.ap_paterno', 'Movimiento.persona_id', 'TIME(Movimiento.modified) as hora')
      ));
      foreach ($datos as $key => $da) {
        $datos_aux = $this->Movimiento->find('all', array(
          'recursive' => 0, 'order' => 'Movimiento.producto_id',
          'conditions' => array('Movimiento.persona_id' => $da['Movimiento']['persona_id'], 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.cliente_id' => $da['Movimiento']['cliente_id'], 'Movimiento.salida !=' => 'null'),
          'group' => array('Movimiento.producto_id', 'Movimiento.precio_uni'),
          'fields' => array('Producto.nombre', 'SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total')
        ));
        $datos[$key]['productos'] = $datos_aux;
      }
      //debug($datos);exit;
    }
    $this->User->virtualFields = array(
      'nombre_completo' => "CONCAT(Persona.nombre,' ',Persona.ap_paterno,' ',Persona.ap_materno)"
    );
    $categorias = $this->Tiposproducto->find('list', array('fields' => 'nombre'));
    $distribuidores = $this->User->find('list', array('recursive' => 0, 'conditions' => array('User.group_id' => 2), 'fields' => array('User.persona_id', 'User.nombre_completo')));
    $this->set(compact('datos', 'distribuidores', 'categorias'));
  }

  public function reporte_pagos() {
    $datos = array();
    if (!empty($this->request->data)) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $tipo = $this->request->data['Dato']['tipo'];
      $sucursal = $this->request->data['Dato']['sucursal'];
      $condiciones = array();
      $condiciones['Pago.created >='] = $fecha_ini;
      $condiciones['Pago.created <='] = $fecha_fin;
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $sucursal),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];
      $condiciones['Ventascelulare.almacene_id'] = $idAlmacen;
      if ($tipo != 'Todos') {
        $condiciones['Pago.tipo'] = $tipo;
      }
      $sql = "SELECT p.nombre FROM productos p WHERE p.id = Ventascelulare.producto_id";
      $this->Pago->virtualFields = array(
        'producto' => "CONCAT(($sql))"
      );
      $datos = $this->Pago->find('all', array(
        'recursive' => 0,
        'conditions' => $condiciones,
        'fields' => array('Ventascelulare.cliente', 'Pago.producto', 'Pago.monto', 'Pago.tipo', 'Pago.codigo', 'Ventascelulare.producto_id', 'Pago.created')
      ));
      /* debug($datos);
        exit; */
    }
    $sucursales = $this->Sucursal->find('list', array('fields' => 'nombre'));
    $this->set(compact('datos', 'sucursales'));
  }

  public function reporte_celular() {
    $datos = array();
    if (!empty($this->request->data)) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $sucursal = $this->request->data['Dato']['sucursal'];
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $sucursal),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.entrada)+SUM(mov.salida)) FROM ventascelulares mov WHERE mov.almacene_id = $idAlmacen AND DATE(mov.created) > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $this->Ventascelulare->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
      );
      $datos = $this->Ventascelulare->find('all', array(
        'recursive' => 0, 'order' => 'Ventascelulare.producto_id',
        'conditions' => array('Ventascelulare.almacene_id' => $idAlmacen, 'DATE(Ventascelulare.created) >=' => $fecha_ini, 'DATE(Ventascelulare.created) <=' => $fecha_fin),
        'group' => array('Ventascelulare.producto_id'),
        'fields' => array('Producto.nombre', 'SUM(Ventascelulare.entrada) entregado', 'SUM(Ventascelulare.salida) vendido', 'Producto.id', 'Ventascelulare.total_s', 'Ventascelulare.precio', 'Ventascelulare.id')
      ));
    }
    $sucursales = $this->Sucursal->find('list', array('fields' => 'nombre'));
    $this->set(compact('datos', 'sucursales'));
  }

  public function reporte_celular_cliente() {
    $datos = array();
    if (!empty($this->request->data)) {
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $sucursal = $this->request->data['Dato']['sucursal'];
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $sucursal),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];
      $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql2 = "(SELECT CONCAT(SUM(mov.entrada)+SUM(mov.salida)) FROM ventascelulares mov WHERE mov.almacene_id = $idAlmacen AND DATE(mov.created) > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $this->Ventascelulare->virtualFields = array(
        'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
      );

      $datos = $this->Ventascelulare->find('all', array(
        'recursive' => 0, 'order' => 'Ventascelulare.producto_id',
        'conditions' => array('Ventascelulare.almacene_id' => $idAlmacen, 'DATE(Ventascelulare.created) >=' => $fecha_ini, 'DATE(Ventascelulare.created) <=' => $fecha_fin, 'Ventascelulare.salida !=' => 0),
        'fields' => array('Producto.nombre', 'Producto.id', 'Ventascelulare.created', 'Ventascelulare.precio', 'Ventascelulare.id', 'Ventascelulare.cliente')
      ));
      foreach ($datos as $key => $da) {
        $datos[$key]['pagos'] = $this->Pago->find('all', array(
          'recursive' => -1,
          'conditions' => array('Pago.ventascelulare_id' => $da['Ventascelulare']['id']),
          'fields' => array('Pago.tipo', 'Pago.monto')
        ));
      }
    }
    $sucursales = $this->Sucursal->find('list', array('fields' => 'nombre'));
    $this->set(compact('datos', 'sucursales'));
  }

  public function report_control_ven_cel() {
    $datos_array = array();
    if (!empty($this->request->data)) {
      $idSucursal = $this->Session->read('Auth.User.sucursal_id');
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $condiciones = array();
      if (!empty($idSucursal)) {
        $condiciones['Almacene.sucursal_id'] = $idSucursal;
      }
      $condiciones['Ventascelulare.almacene_id !='] = 1;
      $condiciones['Ventascelulare.salida >'] = 0;
      $condiciones['Producto.tipo_producto'] = 'CELULARES';
      $condiciones['DATE(Ventascelulare.modified) >='] = $fecha_ini;
      $condiciones['DATE(Ventascelulare.modified) <='] = $fecha_fin;
      $this->Ventascelulare->virtualFields = array(
        'prod_marca' => "(SELECT ma.nombre FROM marcas ma WHERE ma.id = Producto.marca_id)",
        'voucher' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Voucher" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)',
        'ticket' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Ticket" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)',
        'efectivo' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Efectivo" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)',
        'tarjeta' => '(SELECT pa1.monto FROM pagos pa1 WHERE pa1.tipo LIKE "Tarjeta" AND pa1.ventascelulare_id = Ventascelulare.id LIMIT 1)'
      );
      $datos_array = $this->Ventascelulare->find('all', array(
        'recursive' => 0,
        'conditions' => $condiciones,
        'fields' => array('Producto.nombre', 'Ventascelulare.prod_marca', 'Ventascelulare.voucher', 'Ventascelulare.ticket', 'Ventascelulare.efectivo', 'Ventascelulare.tarjeta', 'Ventascelulare.cliente', 'Almacene.nombre')
      ));
    }
    $this->set(compact('datos_array'));
  }

  public function reporte_ven_pa_cel() {
    $datos_array = array();
    $datos = array();
    $cmovimientos = array();

    if (!empty($this->request->data)) {
      //debug($this->request->data);exit;

      $idSucursal = $this->request->data['Dato']['sucursal'];
      $fecha_ini = $this->request->data['Dato']['fecha_ini'];
      $fecha_fin = $this->request->data['Dato']['fecha_fin'];
      $almacen = $this->Almacene->find('first', array(
        'recursives' => -1,
        'conditions' => array('Almacene.sucursal_id' => $idSucursal),
        'fields' => array('Almacene.id')
      ));
      $idAlmacen = $almacen['Almacene']['id'];
      $this->Ventascelulare->virtualFields = array(
        'prod_marca' => "(SELECT ma.nombre FROM marcas ma WHERE ma.id = Producto.marca_id)",
        'voucher' => "(SELECT SUM(pa1.monto) FROM pagos pa1 WHERE pa1.tipo LIKE 'Voucher' AND pa1.ventascelulare_id = Ventascelulare.id AND pa1.created >= '$fecha_ini' AND pa1.created <= '$fecha_fin' GROUP BY pa1.ventascelulare_id)",
        'ticket' => "(SELECT SUM(pa1.monto) FROM pagos pa1 WHERE pa1.tipo LIKE 'Ticket' AND pa1.ventascelulare_id = Ventascelulare.id AND pa1.created >= '$fecha_ini' AND pa1.created <= '$fecha_fin' GROUP BY pa1.ventascelulare_id)",
        'efectivo' => "(SELECT SUM(pa1.monto) FROM pagos pa1 WHERE pa1.tipo LIKE 'Efectivo' AND pa1.ventascelulare_id = Ventascelulare.id AND pa1.created >= '$fecha_ini' AND pa1.created <= '$fecha_fin' GROUP BY pa1.ventascelulare_id)",
        'tarjeta' => "(SELECT SUM(pa1.monto) FROM pagos pa1 WHERE pa1.tipo LIKE 'Tarjeta' AND pa1.ventascelulare_id = Ventascelulare.id AND pa1.created >= '$fecha_ini' AND pa1.created <= '$fecha_fin' GROUP BY pa1.ventascelulare_id)"
      );
      $condiciones = array();
      $condiciones['DATE(Ventascelulare.modified) >='] = $fecha_ini;
      $condiciones['DATE(Ventascelulare.modified) <='] = $fecha_fin;
      $condiciones['DATE(Ventascelulare.modified) <='] = 'CELULARES';
      $condiciones['Almacene.sucursal_id'] = $idSucursal;
      $condiciones['Ventascelulare.salida >'] = 0;
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Ventascelulare.producto_id'] = $this->request->data['Dato']['producto_id'];
      }
      $datos_array = $this->Ventascelulare->find('all', array(
        'recursive' => 0,
        'conditions' => array(
          'DATE(Ventascelulare.modified) >=' => $fecha_ini,
          'DATE(Ventascelulare.modified) <=' => $fecha_fin,
          'Producto.tipo_producto' => 'CELULARES',
          'Almacene.sucursal_id' => $idSucursal,
          'Ventascelulare.salida >' => 0
        ),
        'fields' => array('Producto.nombre', 'Ventascelulare.prod_marca', 'Ventascelulare.voucher', 'Ventascelulare.ticket', 'Ventascelulare.efectivo', 'Ventascelulare.tarjeta', 'Ventascelulare.cliente')
      ));
      $a_total_dolares = $this->Cajachica->find('all', array(
        'recursive' => 0,
        'conditions' => array(
          'Cajachica.fecha >=' => $fecha_ini,
          'Cajachica.fecha <=' => $fecha_fin,
          'Pago.moneda' => 'Dolares',
          'Cajachica.sucursal_id' => $idSucursal,
          'Cajachica.tipo' => 'Ingreso'
        ),
        'group' => array('Cajachica.sucursal_id'),
        'fields' => array('SUM(Pago.monto_dolar) as total_dolares', 'SUM(Pago.monto) as total_dolares_b')
      ));
      $total_dolares = 0.00;
      $total_dolares_b = 0.00;
      if (!empty($a_total_dolares[0])) {
        $total_dolares = $a_total_dolares[0][0]['total_dolares'];
        $total_dolares_b = $a_total_dolares[0][0]['total_dolares_b'];
      }
      //-------------------- Ventas -----------
      $condiciones = array();
      $condiciones['Movimiento.almacene_id'] = $idAlmacen;
      $condiciones['Movimiento.created >='] = $fecha_ini;
      $condiciones['Movimiento.created <='] = $fecha_fin;
      $condiciones['Movimiento.salida !='] = NULL;
      if (!empty($this->request->data['Dato']['tiposproducto_id'])) {
        $condiciones['Producto.tiposproducto_id'] = $this->request->data['Dato']['tiposproducto_id'];
      }
      if (!empty($this->request->data['Dato']['producto_id'])) {
        $condiciones['Producto.id'] = $this->request->data['Dato']['producto_id'];
      }

      $sql1 = "(SELECT IF(ISNULL(SUM(mo.salida)),0,SUM(mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'TIENDA' AND Producto.id = mo.producto_id)";
      $sql2 = "(SELECT IF(ISNULL(SUM(mo.salida)),0,SUM(mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'MAYOR' AND Producto.id = mo.producto_id)";
      $sql3 = "(SELECT IF(ISNULL(SUM(mo.precio_uni*mo.salida)),0,SUM(mo.precio_uni*mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'TIENDA' AND Producto.id = mo.producto_id)";
      $sql4 = "(SELECT IF(ISNULL(SUM(mo.precio_uni*mo.salida)),0,SUM(mo.precio_uni*mo.salida)) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND mo.escala = 'MAYOR' AND Producto.id = mo.producto_id)";

      $sql6 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.almacene_id = $idAlmacen AND Producto.id = mo.producto_id LIMIT 1)";
      $sql5 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE mov.almacene_id = $idAlmacen AND mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
      $sql7 = "(SELECT SUM(mo.ingreso) FROM movimientos mo WHERE mo.almacene_id = $idAlmacen AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND Producto.id = mo.producto_id GROUP BY mo.producto_id LIMIT 1)";
      /* $this->Movimiento->virtualFields = array(
        'ventas' => "CONCAT($sql1)",
        'ventas_mayor' => "CONCAT($sql2)",
        'precio_v_t' => "CONCAT($sql3)",
        'precio_v_mayor' => "CONCAT($sql4)",
        'total_s' => "CONCAT($sql6-(IF(ISNULL($sql5),0,$sql5)))"
        );
        $datos = $this->Movimiento->find('all', array(
        'recursive' => 0, 'order' => 'Movimiento.producto_id',
        'conditions' => $condiciones,
        'group' => array('Movimiento.producto_id'),
        'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.ventas', 'Movimiento.ventas_mayor', 'Movimiento.precio_v_t', 'Movimiento.precio_v_mayor', 'Movimiento.total_s', 'Movimiento.created')
        )); */

      $this->Totale->virtualFields = array(
        'ventas' => "CONCAT($sql1)",
        'ventas_mayor' => "CONCAT($sql2)",
        'precio_v_t' => "CONCAT($sql3)",
        'precio_v_mayor' => "CONCAT($sql4)",
        'total_s' => "CONCAT($sql6-(IF(ISNULL($sql5),0,$sql5)))",
        'entregado' => "($sql7)"
      );
      $datos = $this->Totale->find('all', array(
        'reccursive' => 0,
        'conditions' => array('Totale.almacene_id' => $idAlmacen, 'Producto.tipo_producto <>' => 'CELULARES'),
        'fields' => array('Producto.nombre', 'Producto.id', 'Totale.*')
      ));


      $cmovimientos = $this->Cajachica->find('all', array(
        'recursive' => 0,
        'conditions' => array(
          'Cajachica.sucursal_id' => $idSucursal,
          'Cajachica.fecha >=' => $fecha_ini,
          'Cajachica.fecha <=' => $fecha_fin,
          'Cajachica.pago_id' => NULL,
          'Cajachica.movimiento_id' => NULL
        ),
        'order' => array('Cajachica.id ASC'),
        'fields' => array('Cajachica.*', 'Cajadetalle.*')
      ));
      $total_act = $this->get_total_caja($idSucursal);
      $a_ingresos_pos = $this->Cajachica->find('all', array(
        'recursive' => -1,
        'conditions' => array(
          'Cajachica.sucursal_id' => $idSucursal,
          'Cajachica.fecha >' => $fecha_fin,
          'Cajachica.tipo' => 'Ingreso'
        ),
        'group' => array('Cajachica.sucursal_id'),
        'fields' => array("SUM(Cajachica.monto) as total_ingreso_p")
      ));
      $ingresos_pos = 0.00;
      if (!empty($a_ingresos_pos[0])) {
        $ingresos_pos = $a_ingresos_pos[0][0]['total_ingreso_p'];
      }
      $a_salidas_pos = $this->Cajachica->find('all', array(
        'recursive' => -1,
        'conditions' => array(
          'Cajachica.sucursal_id' => $idSucursal,
          'Cajachica.fecha >' => $fecha_fin,
          'Cajachica.tipo' => 'Gasto'
        ),
        'group' => array('Cajachica.sucursal_id'),
        'fields' => array("SUM(Cajachica.monto) as total_salida_p")
      ));
      $salidas_pos = 0.00;
      if (!empty($a_salidas_pos[0])) {
        $salidas_pos = $a_salidas_pos[0][0]['total_salida_p'];
      }


      $a_ingresos_m = $this->Cajachica->find('all', array(
        'recursive' => -1,
        'conditions' => array(
          'Cajachica.sucursal_id' => $idSucursal,
          'Cajachica.fecha >=' => $fecha_ini,
          'Cajachica.fecha <=' => $fecha_fin,
          'Cajachica.tipo' => 'Ingreso'
        ),
        'group' => array('Cajachica.sucursal_id'),
        'fields' => array("SUM(Cajachica.monto) as total_ingreso_p")
      ));
      $ingresos_m = 0.00;
      if (!empty($a_ingresos_m[0])) {
        $ingresos_m = $a_ingresos_m[0][0]['total_ingreso_p'];
      }
      $a_salidas_m = $this->Cajachica->find('all', array(
        'recursive' => -1,
        'conditions' => array(
          'Cajachica.sucursal_id' => $idSucursal,
          'Cajachica.fecha >=' => $fecha_ini,
          'Cajachica.fecha <=' => $fecha_fin,
          'Cajachica.tipo' => 'Gasto'
        ),
        'group' => array('Cajachica.sucursal_id'),
        'fields' => array("SUM(Cajachica.monto) as total_salida_p")
      ));
      $salidas_m = 0.00;
      if (!empty($a_salidas_m[0])) {
        $salidas_m = $a_salidas_m[0][0]['total_salida_p'];
      }

      $total_a_m = $total_act + $salidas_pos - $ingresos_pos;
      $inicial_c = $total_a_m + $salidas_m - $ingresos_m;
      /* debug($ingresos_m);
        debug($salidas_m);
        debug($inicial_c);
        debug($total_a_m);exit; */
    }
    $productos = $this->Producto->find('list', array(
      'fields' => array('id', 'nombre'),
      'conditions' => array('tipo_producto' => 'CELULARES')
    ));
    if (empty($this->request->data['Dato']['fecha_ini'])) {
      $this->request->data['Dato']['fecha_ini'] = date('Y-m-d');
    }
    if (empty($this->request->data['Dato']['fecha_fin'])) {
      $this->request->data['Dato']['fecha_fin'] = date('Y-m-d');
    }
    $sucursales = $this->Sucursal->find('list', array('fields' => 'nombre'));
    $this->set(compact('sucursales', 'datos_array', 'productos', 'datos', 'cmovimientos', 'inicial_c', 'ingresos_m', 'salidas_m', 'total_a_m', 'total_dolares', 'total_dolares_b'));
  }

  public function get_total_caja($idSucursal = null) {
    $caja = $this->Cajachica->find('first', array(
      'recursive' => -1,
      'conditions' => array('Cajachica.sucursal_id' => $idSucursal),
      'order' => 'id DESC'
    ));
    if (empty($caja)) {
      return 0.00;
    } else {
      return $caja['Cajachica']['total'];
    }
  }

  public function chips_metas() {

    $metas = array();
    $dias_lab = '';
    if (!empty($this->request->data)) {
      $fecha_f = $this->request->data['Dato']['fecha_fin'];
      $fecha_fin = explode('-', $this->request->data['Dato']['fecha_fin']);
      $ano = $fecha_fin[0];
      $mes = $fecha_fin[1];
      //debug($fecha_f);exit;
      $sql1 = "(SELECT COUNT(activados.id) FROM activados WHERE DATE(activados.fecha_act) <= '$fecha_f' AND YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";
      $sql2 = "(SELECT activados.inspector FROM activados WHERE DATE(activados.fecha_act) <= '$fecha_f' AND YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta LIMIT 1)";
      $sql3 = "(SELECT COUNT(activados.id) FROM activados WHERE DATE(activados.fecha_act) <= '$fecha_f' AND YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta AND activados.comercial LIKE 'SI' GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";
      $this->Meta->virtualFields = array(
        'inspector' => "($sql2)",
        'ventas' => "($sql1)",
        'comercial' => "($sql3)"
      );
      $metas = $this->Meta->find('all', array(
        'recursive' => 0,
        'conditions' => array('Meta.anyo' => $ano, 'Meta.mes' => $mes)
      ));
      $dias_lab = $this->countDays($ano, $mes, array(0));
      
    }
    $this->set(compact('metas','dias_lab','mes','ano'));
  }

  function countDays($year, $month, $ignore) {
    $count = 0;
    $counter = mktime(0, 0, 0, $month, 1, $year);
    while (date("n", $counter) == $month) {
      if (in_array(date("w", $counter), $ignore) == false) {
        $count++;
      }
      $counter = strtotime("+1 day", $counter);
    }
    return $count;
  }
}
?>

