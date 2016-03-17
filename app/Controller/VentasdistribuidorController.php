<?php

class VentasdistribuidorController extends AppController {

    public $helpers = array(
        'Html',
        'Form',
        'Js');
    public $uses = array(
        'Cliente',
        'Producto',
        'Persona',
        'Movimiento',
        'Ruteosupervisore',
        'Recarga',
        'Detalleobservacione',
        'Ventasdistribuidore',
        'Productosprecio',
        'Ruteo',
        'Ruta',
        'Chip',
        'Pedido',
        'Lugare',
        'Tiposobservacione',
        'Deposito',
        'Recargado',
        'Listacliente', 'User', 'Rutasusuario', 'Totale', 'Precio','Meta');
    public $layout = 'vivadistribuidor';
    public $components = array('RequestHandler', 'Session', 'Acl', 'Auth', 'DataTable');

    function beforeFilter() {
        parent::beforeFilter();
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

    public function formularioventapormayor() {
        if (!empty($this->request->data)) {
            
        } else {
            
        }
    }

    function index() {
        $id = $this->Session->read('usuario_id');
        $fecha = date("Y-m-d");
        $dia = $this->getday();

        $ruta = $this->Ruteo->find('first', array('conditions' => array('Ruteo.distribuidor_id' =>
                $id, 'Ruteo.dia ' => $dia),));
        //debug($ruta);exit;
        $id_ruta = $ruta['Ruteo']['ruta_id'];
        $idruteo = $ruta['Ruteo']['id'];

        $lista = $this->Cliente->find('all', array('conditions' => array('Cliente.ruta_id' => $id_ruta)));

        //debug($lista);exit;
        //$ventas = $this->Ventaa->find('all', array("conditions" => array("Ventaa.fecha" => $fecha, "Ventaa.usuario_id" => $id)));
        //debug($ventas);exit;
        //$estado = 0;
        $i = 0;
        $cmp = array();


        $this->set(compact('lista', 'cmp', 'ruta'));
    }

    function visitassupervisor() {
        $id = $this->Session->read('usuario_id');
        //debug($id);exit;
        $fecha = date("Y-m-d");
        $dia = $this->getday();
        //debug($dia);exit;
        $ruta = $this->Ruteo->find('first', array('conditions' => array('Ruteo.distribuidor_id' =>
                $id, 'Ruteo.dia ' => $dia), 'fields' => array('Ruteo.id', 'Ruteo.ruta_id')));
        //  debug($ruta);exit;
        $id_ruta = $ruta['Ruteo']['ruta_id'];
        $idruteo = $ruta['Ruteo']['id'];

        $lista = $this->Ruteosupervisore->find('all', array('conditions' => array(
                'Ruteosupervisore.ruta_id' => $id_ruta,
                'Ruteosupervisore.distribuidor_id' => $id,
                'Ruteosupervisore.ruteo_id' => $idruteo), 'order' => array('Ruteosupervisore.orden ASC')));

        $this->set(compact('lista', 'cmp'));
    }

    function pidecodigo() {
        if (!empty($this->request->data)) {
            $codigo = $this->request->data['Cliente']['codigo'];
            $cliente = $this->Cliente->find('first', array(
                'conditions' => array(
                    'Cliente.num_registro' => $codigo
            )));
            if (!empty($cliente)) {
                $idCliente = $cliente['Cliente']['id'];
                $this->redirect(array('action' => 'formulario', $idCliente));
            } else {
                $this->Session->setFlash('No existe el cliente con codigo de registro: ' . $codigo .
                        ', consulte al administrador del sistema');
                $this->redirect(array('action' => 'pidecodigo'), null, true);
            }
        }
    }

    public function registrafecha() {
        if (!empty($this->request->data)) {
            $codigo = $this->request->data['Cliente']['codigo'];
            $fecha = $this->request->data['Cliente']['fecha'];
            $cliente = $this->Cliente->find('first', array(
                'conditions' => array(
                    'Cliente.num_registro' => $codigo
            )));
            if (!empty($cliente)) {
                $idCliente = $cliente['Cliente']['id'];
                $fecha = $this->request->data['Cliente']['fecha'];
                $this->redirect(array('action' => 'formulario2', $idCliente, $fecha));
            } else {
                $this->Session->setFlash('No existe el cliente con codigo de registro: ' . $codigo .
                        ', consulte al administrador del sistema');
                $this->redirect(array('action' => 'pidecodigo'), null, true);
            }
        }
    }

    public function formulario2($id_cli = null, $fecha = null) {
        //debug($fecha);exit;
        //$this->layout= 'ajax';
        $tipo = $this->Session->read('Auth.User.group_id');
        $usu = $this->Session->read('Auth.User.id');
        $usuario = $this->Session->read('Auth.User.persona_id');
        $datoscli = $this->Cliente->findById($id_cli);
        $cod149 = $datoscli['Cliente']['num_registro'];

        if (!empty($this->request->data)) {
            //debug($this->request->data);exit;
            $estado = 0;
            $clienteId = $this->request->data['Ventasdistribuidore']['1']['cliente_id'];
            //debug($clienteId);exit;
            $ventas = $this->request->data['Ventasdistribuidore'];
            foreach ($ventas as $d) {
                if ($d['cantidad'] != 0) {
                    //debug($d);exit;
                    $productoid = $d['producto_id'];
                    $usuario = $d['persona_id'];
                    $estado = 1;
                    $cantidad = $d['cantidad'];

                    $producto = $this->Producto->find('first', array('conditions' => array('Producto.id' =>
                            $productoid)));
                    $prodnomb = $producto['Producto']['nombre'];
                    //**************************************************************

                    $movs = $this->Movimiento->find('first', array(
                        'conditions' => array(
                            'Movimiento.persona_id' => $usuario,
                            'Movimiento.producto_id' => $productoid),
                        'order' => array('Movimiento.id DESC'),
                        'recursive' => -1
                    ));

                    if (empty($movs)) {
                        $this->Session->setFlash('No cuenta con : ' . $prodnomb, 'msgerror');
                        $this->redirect(array('action' => 'formulario', $clienteId), null, true);
                    } elseif ($movs['Movimiento']['total'] != 0 && $movs['Movimiento']['total'] >= $cantidad) {
                        $total_ante = $movs['Movimiento']['total'];
                        /*                         * *verificar esta parte 15 abril 2013** */
                        $fechamov = $movs['Movimiento']['created'];
                        if ($fechamov == $fecha) {
                            $saldo = $movs['Movimiento']['saldo'];
                            $total = $movs['Movimiento']['total'] - $cantidad;
                            $ingreso = $movs['Movimiento']['ingreso'];
                            $venta = $movs['Movimiento']['salida'] + $cantidad;
                        } else {
                            $saldo = $movs['Movimiento']['total'];
                            $total = $movs['Movimiento']['total'] - $cantidad;
                            $ingreso = 0;
                            $venta = $cantidad;
                        }

                        // debug($total_ante);exit;
                        if ($total_ante >= $cantidad) {

                            //**************************************************************
                            //guarda la venta
                            //**************************************************************
                            $this->Ventasdistribuidore->create();
                            //$d['Ventasdistribuidore']['created'] = $fecha;
                            if (!($this->Ventasdistribuidore->save($d))) {
                                $this->Session->setFlash('No se pudo guardar la venta del producto: ' . $prodnomb .
                                        ', consulte al administrador del sistema', 'msgerror');
                                $this->redirect(array('action' => 'formulario', $this->data['0']['Ventasdistribuidore']['cliente_id']), null, true);
                            } else {
                                $idventa = $this->Ventasdistribuidore->getLastInsertID();
                            }
                        } else {
                            $this->Session->setFlash('no le alcanzan: ' . $prodnomb .
                                    '. Ingrese los datos de venta nuevamente!!', 'msgerror');
                            $this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id' => $idventa));
                            $this->redirect(array('action' => 'formulario', $clienteId), null, true);
                        }
                        //debug($idventa);exit;
                        //**************************************************************
                        //guarda el movimiento de la venta
                        //**************************************************************

                        $this->Movimiento->create();

                        $this->request->data['Movimiento']['producto_id'] = $productoid;
                        $this->request->data['Movimiento']['user_id'] = $usu;
                        $this->request->data['Movimiento']['persona_id'] = $usuario;
                        $this->request->data['Movimiento']['ingreso'] = $ingreso;
                        $this->request->data['Movimiento']['saldo'] = $saldo;
                        $this->request->data['Movimiento']['salida'] = $venta;
                        $this->request->data['Movimiento']['total'] = $total;
                        $this->request->data['Movimiento']['ventasdistribuidore_id'] = $idventa;
                        $this->request->data['Movimiento']['created'] = $fecha;
                        //debug($fecha);
                        //debug($this->request->data['Movimiento']);exit;
                        if (!($this->Movimiento->save($this->request->data['Movimiento']))) {
                            $this->Session->setFlash('No se pudo guardar el movimiento del producto:' . $prodnomb .
                                    ', consulte al administrador del sistema', 'msgerror');
                            $this->redirect(array('action' => 'formulario', $this->request->data['0']['Ventasdistribuidore']['cliente_id']), null, true);
                        }

                        //**************************************************************
                    } elseif ($movs['Movimiento']['total'] == 0) {
                        //debug($movs);exit;
                        $this->Session->setFlash('Ya no le sobran o no le alcanzan: ' . $prodnomb .
                                '. Ingrese los datos de venta nuevamente!!', 'msgerror');
                        //$this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id'=>$idventa));
                        $this->redirect(array('action' => 'formulario', $clienteId), null, true);
                    } else {
                        $this->Session->setFlash('Ud. no cuenta con: ' . $prodnomb .
                                '. Ingrese los datos de venta nuevamente!!', 'msgerror');
                        //$this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id'=>$idventa));
                        $this->redirect(array('action' => 'formulario', $clienteId), null, true);
                    }

                    //**************************************************************
                } //fin del if decantidad != 0
                else {
                    $this->Ventasdistribuidore->create();
                    $this->Ventasdistribuidore->save($d);
                }
            } //end del recorrido de datos del thisdata


            $recargas = $this->request->data['Recarga'];

            if (!empty($recargas)) {
                foreach ($recargas as $data) {
                    //debug($r);exit;

                    if (!empty($data['monto'])) {
                        //debug($data);
                        $this->Recarga->create();
                        if (!($this->Recarga->save($data))) {
                            $this->Session->setFlash('No se pudo registrar una de las recargas el registro del pago de recargas', 'msgerror');
                            $this->redirect(array('action' => 'index'), null, true);
                        } else {
                            $this->requestAction(array('controller' => 'Recargas', 'action' => 'notifica'));
                        }
                    }
                }
            }

            $this->Session->setFlash('Venta registrada!!!!!', 'msgbueno');
            $this->redirect(array('action' => 'pidecodigo'), null, true);
        } else {

            $precios = $this->Productosprecio->find('all', array(
                'conditions' => array(
                    'Productosprecio.tipousuario_id' => 3,
                    'Producto.proveedor like' => 'VIVA',
                    'Producto.estado' => '1'),
                'order' => array('Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
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


            //$this->set(compact('precios', 'rows', 'usu', 'datoscli', 'recargas'));
            $this->set(compact('precios', 'rows', 'usuario', 'usu', 'datoscli', 'recargas', 'fecha', 'id_cli', 'fecha'));
        }
    }

    function formulario($id_cli = null, $num_trans = null) {
        $usu = $this->Session->read('Auth.User.id');
        $usuario = $this->Session->read('Auth.User.persona_id');
        $datoscli = $this->Cliente->findById($id_cli);
        $precios = $this->Productosprecio->find('all', array(
            'conditions' => array(
                'Productosprecio.tipousuario_id' => 3,
                //'Producto.proveedor like' => 'VIVA',
                'Productosprecio.escala' => 'MAYOR',
                'Producto.estado' => '1'),
            'order' => array('Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
                'Productosprecio.escala')));

        $rows = $this->Productosprecio->find('all', array(
            'conditions' => array(
                'Productosprecio.tipousuario_id' => 3,
                //'Producto.proveedor like' => 'VIVA',
                'Productosprecio.escala' => 'MAYOR',
                'Producto.estado' => '1'),
            'fields' => array(
                'Count(Productosprecio.id) as cantidad',
                'Producto.nombre',
                'Producto.id'),
            'group' => array('Productosprecio.producto_id')));

        if ($this->Session->check('form_venta_mayor')) {
            $this->request->data = $this->Session->read('form_venta_mayor');
            $this->Session->delete('form_venta_mayor');
        }
        $this->set(compact('precios', 'rows', 'usuario', 'usu', 'datoscli', 'recargas', 'num_trans'));
    }

    public function registra_venta_mayor() {
        /* debug($this->request->data);
          exit; */
        foreach ($this->request->data['Movimiento'] as $dat) {
            $total = $this->get_total($dat['producto_id'], 0, $this->Session->read('Auth.User.persona_id'));
            if ($dat['salida'] > 0) {
                if ($dat['salida'] > $total) {
                    $this->Session->write('form_venta_mayor', $this->request->data);
                    $this->Session->setFlash('Solo hay ' . $total . ' unidades de ' . $dat['nombre_prod'] . '!!!', 'msgerror');
                    $this->redirect(array('action' => 'formulario', $this->request->data['Ventastienda']['cliente_id']));
                }
            }
        }
        $num_transaccion = $this->get_num_trans();
        foreach ($this->request->data['Movimiento'] as $dat) {
            $total = $this->get_total($dat['producto_id'], 0, $this->Session->read('Auth.User.persona_id'));
            $this->Movimiento->create();
            //$dat['total'] = $total - $dat['salida'];
            $dat['transaccion'] = $num_transaccion;
            $dat['capacitacion'] = $this->request->data['Aux']['capacitacion'];
            $dat['est_punt'] = $this->request->data['Aux']['est_punt'];
            $this->Movimiento->save($dat);
            if (!empty($dat['id'])) {
                $total = $total + $dat['salida_ant'];
            }
            $this->set_total($dat['producto_id'], 0, $this->Session->read('Auth.User.persona_id'), ($total - $dat['salida']));
        }
        //$this->registra_recarga();
        $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
        $this->redirect(array('action' => 'clientes'));
    }

    public function registra_venta_mayor_ajax($persona = null) {
        /* debug($this->request->data);
          exit; */

        foreach ($this->request->data['Movimiento'] as $dat) {
            $total = $this->get_total($dat['producto_id'], 0, $persona);
            if ($dat['salida'] > 0) {
                if ($dat['salida'] > $total) {
                    $this->Session->setFlash('Solo hay ' . $total . ' unidades de ' . $dat['nombre_prod'] . '!!!', 'msgerror');
                    $this->redirect($this->referer());
                }
            }
        }

        foreach ($this->request->data['Movimiento'] as $dat) {
            $num_transaccion = $this->get_num_trans();
            $total = $this->get_total($dat['producto_id'], 0, $persona);
            $this->Movimiento->create();
            //$dat['total'] = $total - $dat['salida'];
            $dat['transaccion'] = $num_transaccion;
            $dat['capacitacion'] = $this->request->data['Aux']['capacitacion'];
            $dat['est_punt'] = $this->request->data['Aux']['est_punt'];
            $this->Movimiento->save($dat);
            if (!empty($dat['id'])) {
                $total = $total + $dat['salida_ant'];
            }
            $this->set_total($dat['producto_id'], 0, $persona, ($total - $dat['salida']));
        }
        $this->Session->setFlash('Se registro correctamente!!!', 'msgbueno');
        $this->redirect($this->referer());
    }

    public function get_total_dis($idProducto = null) {
        $movimiento = $this->Movimiento->find('first', array(
            'order' => 'Movimiento.id DESC',
            'conditions' => array('Movimiento.persona_id' => $this->Session->read('Auth.User.persona_id'), 'Movimiento.producto_id' => $idProducto)
        ));
        /* debug($movimiento);
          exit; */
        if (!empty($movimiento)) {
            return $movimiento['Movimiento']['total'];
        } else {
            return 0;
        }
    }

    public function registra_recarga() {
        $recargas = $this->request->data['Recarga'];
        if (!empty($recargas)) {
            foreach ($recargas as $data) {
                if (!empty($data['monto'])) {
                    //debug($data);
                    $this->Recarga->create();
                    $this->Recarga->save($data);
                }
            }
        }
    }

    function vermapa($id = null) {
        $cliente = $this->Cliente->findById($id);
        //           debug($cliente);
        $this->set(compact('cliente'));
    }

    function ajaxmapa($id = null) {
        $this->layout = "ajax";
        //debug($idmapa);
        // $img = $this->Ruta->findById($idmapa);
        //debug($img);
        // $direccion = $img['Ruta']['dir_imagen'];
        // $imagen = $img['Ruta']['imagen'];
        // $this->set(compact('direccion', 'imagen'));
        $cliente = $this->Cliente->findById($id);
        //           debug($cliente);
        $this->set(compact('cliente'));
    }

    function ajaxobs($id_cli = null) {
        $this->layout = "ajax";

        if (!empty($this->data)) {
            //debug($this->data);exit;
            $this->Detalleobservacione->create();

            if ($this->Detalleobservacione->save($this->data)) {
                $this->Session->setFlash('Los datos fueron modificados');
                $this->redirect(array('action' => 'index'), null, true);
            } else {
                $this->Session->setFlash('no se pudo modificar!!');
            }
        } else {
            $idusu = $this->Session->read('usuario_id');
            $obse = $this->Tiposobservacione->find('list', array('fields' => array('Tiposobservacione.id',
                    'Tiposobservacione.nombre')));
            $this->set(compact('obse', 'id_cli', 'idusu'));
        }
    }

    public function reporte1492() {
        $this->layout = "imprimetabla";
        $usuario_id = $this->Session->read('Auth.User.id');

        $distribuidor = $this->Session->read('Auth.User.Persona.nombre');
        $persona = $this->Session->read('Auth.User.Persona.id');
        $hoy = date('Y-m-d');
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
        $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'distribuidor', 'deposito'));
    }

    public function reporte1492nuevo($hoy = null) {
        //debug($hoy);exit;
        $this->layout = "imprimetabla";
        $usuario_id = $this->Session->read('Auth.User.id');

        $distribuidor = $this->Session->read('Auth.User.Persona.nombre');
        $persona = $this->Session->read('Auth.User.Persona.id');
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
        $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'distribuidor', 'deposito'));
    }

    public function reporte1492fecha() {
        //debug($this->request->data['Ventasdistribuidor']['fecha']);exit;
        if ($this->request->data['Ventasdistribuidor']['fecha'] != null) {
            $this->redirect(array('controller' => 'Ventasdistribuidor', 'action' => 'reporte1492nuevo', $this->request->data['Ventasdistribuidor']['fecha']), null, true);
        }
    }

    //reporte por clientes para distirbuidor
    function reporte149() {
        $this->layout = 'default';
        $usuario_id = $this->Session->read('Auth.User.id');

        $distribuidor = $this->Session->read('Auth.User.Persona.nombre');

        $hoy = date('Y-m-d');
        $dia = $hoy;
        $precios = $this->Productosprecio->find('all', array(
            'conditions' => array(
                'Productosprecio.tipousuario_id' => 3,
                'Producto.proveedor like' => 'VIVA',
                'Producto.estado' => '1'),
            'order' => array('Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
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
        //debug($rows);exit;
//debug($hoy);exit;
        $ventas = $this->Ventasdistribuidore->find('all', array(
            'conditions' => array('Ventasdistribuidore.fecha' => $hoy, 'Ventasdistribuidore.user_id' => $usuario_id),
            'order' => array('Ventasdistribuidore.cliente_id ASC', 'Ventasdistribuidore.producto_id ASC', 'Ventasdistribuidore.precio DESC')));
        // debug($ventas);
        $clientes = $this->Ventasdistribuidore->find('all', array(
            'conditions' => array('Ventasdistribuidore.fecha' => $hoy, 'Ventasdistribuidore.user_id' => $usuario_id),
            'group' => array('Ventasdistribuidore.cliente_id'),
            'order' => array('Ventasdistribuidore.cliente_id ASC')
        ));
        // debug($clientes);exit;
        $sql = "SELECT * FROM recargas WHERE recargas.created like '$hoy' AND recargas.user_id = '$usuario_id'";
        //debug($sql);exit;

        $recargas = $this->Recarga->find('all', array('conditions' => array('Recarga.created' => $hoy, 'Recarga.user_id' => $usuario_id)));
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
        $this->set(compact('recargas', 'obs', 'ventas', 'hoy', 'distribuidor'));
    }

    public function deposito() {
        debug($this->request->data);
        exit;
    }

    //fin reportes por cliente distribuidor
    public function cambiopass($id = null) {
        $this->User->id = $id;
        if (!$id) {
            $this->Session->setFlash('No existe tal registro');
            $this->redirect(array('action' => 'index'), null, true);
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read();
        } else {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Su Password fue modificado Exitosamente');
                $this->redirect(array('action' => 'index'), null, true);
            } else {
                $this->Session->setFlash('no se pudo modificar!!');
            }
        }
    }

    function pidecodigo_mobile() {
        $this->layout = 'vivadistribuidor_mobile';
        if (!empty($this->request->data)) {
            $codigo = $this->request->data['Cliente']['codigo'];
            $cliente = $this->Cliente->find('first', array(
                'conditions' => array(
                    'Cliente.num_registro' => $codigo
            )));
            if (!empty($cliente)) {
                $idCliente = $cliente['Cliente']['id'];
                $this->redirect(array('action' => 'formulario_mobile', $idCliente));
                //$this->render('formulario_mobile');
            } else {
                $this->Session->setFlash('No existe el cliente con codigo de registro: ' . $codigo .
                        ', consulte al administrador del sistema', 'msgerror_mobil');
                $this->redirect(array('action' => 'pidecodigo_mobile'));
            }
        }
    }

    function formulario_mobile($id_cli = null) {
        //$this->layout= 'ajax';
        $this->layout = 'vivadistribuidor_mobile';
        $tipo = $this->Session->read('Auth.User.group_id');
        $usu = $this->Session->read('Auth.User.id');
        $usuario = $this->Session->read('Auth.User.persona_id');
        $datoscli = $this->Cliente->findById($id_cli);
        $cod149 = $datoscli['Cliente']['num_registro'];

        if (!empty($this->request->data)) {
            //debug($this->request->data);exit;
            $estado = 0;
            $fecha = date('Y-m-d');
            $clienteId = $this->request->data['Ventasdistribuidore']['1']['cliente_id'];
            //debug($clienteId);exit;
            $ventas = $this->request->data['Ventasdistribuidore'];
            foreach ($ventas as $d) {
                if ($d['cantidad'] != 0) {
                    //debug($d);exit;
                    $productoid = $d['producto_id'];
                    $usuario = $d['persona_id'];
                    $estado = 1;
                    $cantidad = $d['cantidad'];

                    $producto = $this->Producto->find('first', array('conditions' => array('Producto.id' =>
                            $productoid)));
                    $prodnomb = $producto['Producto']['nombre'];
                    //**************************************************************

                    $movs = $this->Movimiento->find('first', array(
                        'conditions' => array(
                            'Movimiento.persona_id' => $usuario,
                            'Movimiento.producto_id' => $productoid),
                        'order' => array('Movimiento.id DESC'),
                        'recursive' => -1
                    ));

                    if (empty($movs)) {
                        $this->Session->setFlash('No cuenta con : ' . $prodnomb, 'msgerror_mobil');
                        $this->redirect(array('action' => 'formulario_mobile', $clienteId), null, true);
                    } elseif ($movs['Movimiento']['total'] != 0 && $movs['Movimiento']['total'] >= $cantidad) {
                        $total_ante = $movs['Movimiento']['total'];
                        /*                         * *verificar esta parte 15 abril 2013** */
                        $fechamov = $movs['Movimiento']['created'];
                        if ($fechamov == date('Y-m-d')) {
                            $saldo = $movs['Movimiento']['saldo'];
                            $total = $movs['Movimiento']['total'] - $cantidad;
                            $ingreso = $movs['Movimiento']['ingreso'];
                            $venta = $movs['Movimiento']['salida'] + $cantidad;
                        } else {
                            $saldo = $movs['Movimiento']['total'];
                            $total = $movs['Movimiento']['total'] - $cantidad;
                            $ingreso = 0;
                            $venta = $cantidad;
                        }
                        // debug($total_ante);exit;
                        if ($total_ante >= $cantidad) {

                            //**************************************************************
                            //guarda la venta
                            //**************************************************************
                            $this->Ventasdistribuidore->create();
                            if (!($this->Ventasdistribuidore->save($d))) {
                                $this->Session->setFlash('No se pudo guardar la venta del producto: ' . $prodnomb .
                                        ', consulte al administrador del sistema', 'msgerror_mobil');
                                $this->redirect(array('action' => 'formulario_mobile', $this->data['0']['Ventasdistribuidore']['cliente_id']), null, true);
                            } else {
                                $idventa = $this->Ventasdistribuidore->getLastInsertID();
                            }
                        } else {
                            $this->Session->setFlash('no le alcanzan: ' . $prodnomb .
                                    '. Ingrese los datos de venta nuevamente!!', 'msgerror_mobil');
                            $this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id' => $idventa));
                            $this->redirect(array('action' => 'formulario_mobile', $clienteId), null, true);
                        }
                        //debug($idventa);exit;
                        //**************************************************************
                        //guarda el movimiento de la venta
                        //**************************************************************

                        $this->Movimiento->create();

                        $this->request->data['Movimiento']['producto_id'] = $productoid;
                        $this->request->data['Movimiento']['user_id'] = $usu;
                        $this->request->data['Movimiento']['persona_id'] = $usuario;
                        $this->request->data['Movimiento']['ingreso'] = $ingreso;
                        $this->request->data['Movimiento']['saldo'] = $saldo;
                        $this->request->data['Movimiento']['salida'] = $venta;
                        $this->request->data['Movimiento']['total'] = $total;
                        $this->request->data['Movimiento']['ventasdistribuidore_id'] = $idventa;

                        //debug($this->request->data['Movimiento']);exit;
                        if (!($this->Movimiento->save($this->request->data['Movimiento']))) {
                            $this->Session->setFlash('No se pudo guardar el movimiento del producto:' . $prodnomb .
                                    ', consulte al administrador del sistema', 'msgerror_mobil');
                            $this->redirect(array('action' => 'formulario_mobile', $this->request->data['0']['Ventasdistribuidore']['cliente_id']), null, true);
                        }

                        //**************************************************************
                    } elseif ($movs['Movimiento']['total'] == 0) {
                        //debug($movs);exit;
                        $this->Session->setFlash('Ya no le sobran o no le alcanzan: ' . $prodnomb .
                                '. Ingrese los datos de venta nuevamente!!', 'msgerror_mobil');
                        //$this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id'=>$idventa));
                        $this->redirect(array('action' => 'formulario_mobile', $clienteId), null, true);
                    } else {
                        $this->Session->setFlash('Ud. no cuenta con: ' . $prodnomb .
                                '. Ingrese los datos de venta nuevamente!!', 'msgerror_mobil');
                        //$this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id'=>$idventa));
                        $this->redirect(array('action' => 'formulario_mobile', $clienteId), null, true);
                    }

                    //**************************************************************
                } //fin del if decantidad != 0
                else {
                    $this->Ventasdistribuidore->create();
                    $this->Ventasdistribuidore->save($d);
                }
            } //end del recorrido de datos del thisdata


            $recargas = $this->request->data['Recarga'];

            if (!empty($recargas)) {
                foreach ($recargas as $data) {
                    //debug($r);exit;
//                        $id = $r['Recarga']['id'];
//                        $this->Recarga->id = $id;
//                        $this->data = $this->Recarga->read();
//                        $this->request->data['Recarga']['estado'] = 1;
                    if (!empty($data['monto'])) {
                        //debug($data);
                        $this->Recarga->create();
                        if (!($this->Recarga->save($data))) {
                            $this->Session->setFlash('No se pudo registrar una de las recargas el registro del pago de recargas', 'msgerror_mobil');
                            $this->redirect(array('action' => 'index'), null, true);
                        } else {
                            $this->requestAction(array('controller' => 'Recargas', 'action' => 'notifica'));
                        }
                    }
                }
            }

            $this->Session->setFlash('Venta registrada!!!!!', 'msgbueno_mobil');
            $this->redirect(array('action' => 'pidecodigo_mobile'), null, true);
        } else {


            $fecha = date('Y-m-d');
            /* $recargas = $this->Recarga->find('all', array('conditions' => array(
              'Recarga.cod149' => $cod149,
              'Recarga.distribuidor_id' => $usu,
              'Recarga.fecha' => $fecha))); */
            // debug($recargas);exit;
            $precios = $this->Productosprecio->find('all', array(
                'conditions' => array(
                    'Productosprecio.tipousuario_id' => 3,
                    'Producto.proveedor like' => 'VIVA',
                    'Producto.estado' => '1'),
                'order' => array('Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
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


            //$this->set(compact('precios', 'rows', 'usu', 'datoscli', 'recargas'));
            $this->set(compact('precios', 'rows', 'usuario', 'usu', 'datoscli', 'recargas'));
        }
    }

    public function registrafecha_mobile() {
        $this->layout = 'vivadistribuidor_mobile';
        if (!empty($this->request->data)) {
            $codigo = $this->request->data['Cliente']['codigo'];
            $fecha = $this->request->data['Cliente']['fecha'];
            $cliente = $this->Cliente->find('first', array(
                'conditions' => array(
                    'Cliente.num_registro' => $codigo
            )));
            if (!empty($cliente)) {
                $idCliente = $cliente['Cliente']['id'];
                $fecha = $this->request->data['Cliente']['fecha'];
                list($mes, $d�a, $a�o) = explode('/', $fecha);
                /* debug($mes);
                  debug($d�a);
                  debug($a�o);exit; */
                //debug($this->request->data);exit;
                $this->redirect(array('action' => 'formulario2_mobile', $idCliente, $a�o.'-'.$mes.'-'.$d�a));
            } else {
                $this->Session->setFlash('No existe el cliente con codigo de registro: ' . $codigo .
                        ', consulte al administrador del sistema', 'msgerror_mobil');
                $this->redirect(array('action' => 'pidecodigo_mobile'), null, true);
            }
        }
    }

    public function login() {
        $this->layout = 'login_mobile';
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {

                $this->redirect(array('action' => 'pidecodigo_mobile'));
            } else {
                $this->Session->setFlash('Usuario o password incorrectos', 'msgerror_mobil');
            }
        }
    }

    public function formulario2_mobile($id_cli = null, $fecha = null) {
        //debug($fecha);exit;
        $this->layout = 'vivadistribuidor_mobile';
        $tipo = $this->Session->read('Auth.User.group_id');
        $usu = $this->Session->read('Auth.User.id');
        $usuario = $this->Session->read('Auth.User.persona_id');
        $datoscli = $this->Cliente->findById($id_cli);
        $cod149 = $datoscli['Cliente']['num_registro'];

        if (!empty($this->request->data)) {
            //debug($this->request->data);exit;
            $estado = 0;
            $clienteId = $this->request->data['Ventasdistribuidore']['1']['cliente_id'];
            //debug($clienteId);exit;
            $ventas = $this->request->data['Ventasdistribuidore'];
            foreach ($ventas as $d) {
                if ($d['cantidad'] != 0) {
                    //debug($d);exit;
                    $productoid = $d['producto_id'];
                    $usuario = $d['persona_id'];
                    $estado = 1;
                    $cantidad = $d['cantidad'];

                    $producto = $this->Producto->find('first', array('conditions' => array('Producto.id' =>
                            $productoid)));
                    $prodnomb = $producto['Producto']['nombre'];
                    //**************************************************************

                    $movs = $this->Movimiento->find('first', array(
                        'conditions' => array(
                            'Movimiento.persona_id' => $usuario,
                            'Movimiento.producto_id' => $productoid),
                        'order' => array('Movimiento.id DESC'),
                        'recursive' => -1
                    ));

                    if (empty($movs)) {
                        $this->Session->setFlash('No cuenta con : ' . $prodnomb, 'msgerror_mobil');
                        $this->redirect(array('action' => 'formulario2_mobile', $clienteId), null, true);
                    } elseif ($movs['Movimiento']['total'] != 0 && $movs['Movimiento']['total'] >= $cantidad) {
                        $total_ante = $movs['Movimiento']['total'];
                        /*                         * *verificar esta parte 15 abril 2013** */
                        $fechamov = $movs['Movimiento']['created'];
                        if ($fechamov == $fecha) {
                            $saldo = $movs['Movimiento']['saldo'];
                            $total = $movs['Movimiento']['total'] - $cantidad;
                            $ingreso = $movs['Movimiento']['ingreso'];
                            $venta = $movs['Movimiento']['salida'] + $cantidad;
                        } else {
                            $saldo = $movs['Movimiento']['total'];
                            $total = $movs['Movimiento']['total'] - $cantidad;
                            $ingreso = 0;
                            $venta = $cantidad;
                        }

                        // debug($total_ante);exit;
                        if ($total_ante >= $cantidad) {

                            //**************************************************************
                            //guarda la venta
                            //**************************************************************
                            $this->Ventasdistribuidore->create();
                            //$d['Ventasdistribuidore']['created'] = $fecha;
                            if (!($this->Ventasdistribuidore->save($d))) {
                                $this->Session->setFlash('No se pudo guardar la venta del producto: ' . $prodnomb .
                                        ', consulte al administrador del sistema', 'msgerror_mobil');
                                $this->redirect(array('action' => 'formulario2_mobile', $this->data['0']['Ventasdistribuidore']['cliente_id']), null, true);
                            } else {
                                $idventa = $this->Ventasdistribuidore->getLastInsertID();
                            }
                        } else {
                            $this->Session->setFlash('no le alcanzan: ' . $prodnomb .
                                    '. Ingrese los datos de venta nuevamente!!', 'msgerror_mobil');
                            $this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id' => $idventa));
                            $this->redirect(array('action' => 'formulario2_mobile', $clienteId), null, true);
                        }
                        //debug($idventa);exit;
                        //**************************************************************
                        //guarda el movimiento de la venta
                        //**************************************************************

                        $this->Movimiento->create();

                        $this->request->data['Movimiento']['producto_id'] = $productoid;
                        $this->request->data['Movimiento']['user_id'] = $usu;
                        $this->request->data['Movimiento']['persona_id'] = $usuario;
                        $this->request->data['Movimiento']['ingreso'] = $ingreso;
                        $this->request->data['Movimiento']['saldo'] = $saldo;
                        $this->request->data['Movimiento']['salida'] = $venta;
                        $this->request->data['Movimiento']['total'] = $total;
                        $this->request->data['Movimiento']['ventasdistribuidore_id'] = $idventa;
                        $this->request->data['Movimiento']['created'] = $fecha;
                        //debug($fecha);
                        //debug($this->request->data['Movimiento']);exit;
                        if (!($this->Movimiento->save($this->request->data['Movimiento']))) {
                            $this->Session->setFlash('No se pudo guardar el movimiento del producto:' . $prodnomb .
                                    ', consulte al administrador del sistema', 'msgerror_mobil');
                            $this->redirect(array('action' => 'formulario2_mobile', $this->request->data['0']['Ventasdistribuidore']['cliente_id']), null, true);
                        }

                        //**************************************************************
                    } elseif ($movs['Movimiento']['total'] == 0) {
                        //debug($movs);exit;
                        $this->Session->setFlash('Ya no le sobran o no le alcanzan: ' . $prodnomb .
                                '. Ingrese los datos de venta nuevamente!!', 'msgerror_mobil');
                        //$this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id'=>$idventa));
                        $this->redirect(array('action' => 'formulario2_mobile', $clienteId), null, true);
                    } else {
                        $this->Session->setFlash('Ud. no cuenta con: ' . $prodnomb .
                                '. Ingrese los datos de venta nuevamente!!', 'msgerror_mobil');
                        //$this->Movimiento->deleteAll(array('Movimiento.ventasdistribuidore_id'=>$idventa));
                        $this->redirect(array('action' => 'formulario2_mobile', $clienteId), null, true);
                    }

                    //**************************************************************
                } //fin del if decantidad != 0
                else {
                    $this->Ventasdistribuidore->create();
                    $this->Ventasdistribuidore->save($d);
                }
            } //end del recorrido de datos del thisdata


            $recargas = $this->request->data['Recarga'];

            if (!empty($recargas)) {
                foreach ($recargas as $data) {
                    //debug($r);exit;

                    if (!empty($data['monto'])) {
                        //debug($data);
                        $this->Recarga->create();
                        if (!($this->Recarga->save($data))) {
                            $this->Session->setFlash('No se pudo registrar una de las recargas el registro del pago de recargas', 'msgerror_mobil');
                            $this->redirect(array('action' => 'registrafecha_mobile'), null, true);
                        } else {
                            $this->requestAction(array('controller' => 'Recargas', 'action' => 'notifica'));
                        }
                    }
                }
            }

            $this->Session->setFlash('Venta registrada!!!!!', 'msgbueno_mobil');
            $this->redirect(array('action' => 'registrafecha_mobile'), null, true);
        } else {

            $precios = $this->Productosprecio->find('all', array(
                'conditions' => array(
                    'Productosprecio.tipousuario_id' => 3,
                    'Producto.proveedor like' => 'VIVA',
                    'Producto.estado' => '1'),
                'order' => array('Producto.tipo_producto DESC', 'Productosprecio.precio DESC',
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


            //$this->set(compact('precios', 'rows', 'usu', 'datoscli', 'recargas'));
            $this->set(compact('precios', 'rows', 'usuario', 'usu', 'datoscli', 'recargas', 'fecha', 'id_cli', 'fecha'));
        }
    }

    public function salir() {
        //$this->Session->setFlash('Good-Bye');
        $this->Auth->logout();
        $this->redirect(array('controller' => 'Ventasdistribuidor', 'action' => 'login'));
    }

    public function reporte1492_mobile() {
        $this->layout = "vivadistribuidor_mobile";
        $usuario_id = $this->Session->read('Auth.User.id');

        $distribuidor = $this->Session->read('Auth.User.Persona.nombre');
        $persona = $this->Session->read('Auth.User.Persona.id');
        $hoy = date('Y-m-d');
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
        //debug($rows);exit;
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
        $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'distribuidor', 'deposito'));
    }

    public function reporte1492fecha_mobile() {
        $this->layout = 'vivadistribuidor_mobile';
        //debug($this->request->data['Ventasdistribuidor']['fecha']);exit;
        $fecha = $this->request->data['Ventasdistribuidor']['fecha'];
        list($mes, $d�a, $a�o) = explode('/', $fecha);
        if ($this->request->data['Ventasdistribuidor']['fecha'] != null) {
            $this->redirect(array('controller' => 'Ventasdistribuidor', 'action' => 'reporte1492nuevo_mobile', $a�o.'-'.$mes.'-'.$d�a), null, true);
        }
    }

    public function reporte1492nuevo_mobile($hoy = null) {
        //debug($hoy);exit;
        $this->layout = "vivadistribuidor_mobile";
        $usuario_id = $this->Session->read('Auth.User.id');

        $distribuidor = $this->Session->read('Auth.User.Persona.nombre');
        $persona = $this->Session->read('Auth.User.Persona.id');
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
        $this->set(compact('precios', 'rows', 'clientes', 'recargas', 'obs', 'ventas', 'hoy', 'distribuidor', 'deposito'));
    }

    public function cambiopass_mobile() {
        $this->layout = 'vivadistribuidor_mobile';
        $id = $this->Session->read('Auth.User.id');
        $this->User->id = $id;
        if (!$id) {
            $this->Session->setFlash('No existe tal registro');
            $this->redirect(array('action' => 'index'), null, true);
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read();
        } else {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Su Password fue modificado Exitosamente', 'msgbueno_mobil');
                $this->redirect(array('action' => 'pidecodigo_mobile'), null, true);
            } else {
                $this->Session->setFlash('no se pudo modificar!!', 'msgerror_mobil');
            }
        }
    }

    public function clientes() {

        if ($this->RequestHandler->responseType() == 'json') {
            $asignar = '<button class="button blue-gradient icon-star" type="button" onclick="asignar(' . "',Cliente.id,'" . ')"></button>';
            //$asignar = '<button class="button blue-gradient compact icon-list" type="button" onclick="asignar(' . "',Cliente.id,'" . ')">Asignar</button>';
            //$venta = '<button class="button green-gradient compact icon-list" type="button" onclick="venta(' . "',Cliente.id,'" . ')">Venta</button>';
            //$editar = '<button class="button orange-gradient compact icon-list" type="button" onclick="editar(' . "',Cliente.id,'" . ')">Editar</button>';
            //$editar2 = "',IF((Cliente.estado = 1),CONCAT('$editar'),''),'";
            //$acciones = "$asignar $venta $editar2";
            $acciones = "$asignar";
            $rutas_usuario = $this->Rutasusuario->find('list', array(
                'conditions' => array('Rutasusuario.user_id' => $this->Session->read('Auth.User.id')),
                'fields' => array('Rutasusuario.ruta_id')
            ));
            //debug($rutas_usuario);exit;
            $this->Cliente->virtualFields = array(
                'acciones' => "CONCAT('$acciones')"
            );
            $this->paginate = array(
                'fields' => array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Cliente.zona', 'Cliente.acciones'),
                'recursive' => -1,
                'order' => 'Cliente.id DESC',
                'conditions' => array('Cliente.ruta_id' => $rutas_usuario)
            );
            $this->DataTable->fields = array('Cliente.num_registro', 'Cliente.nombre', 'Cliente.direccion', 'Cliente.celular', 'Cliente.zona', 'Cliente.acciones');
            //$this->DataTable->emptyEleget_usuarios_adminments = 1;
            $this->set('clientes', $this->DataTable->getResponse('Ventasdistribuidor', 'Cliente'));
            $this->set('_serialize', 'clientes');
        }
    }

    public function chips($idCliente = null) {
        $cliente = $this->Cliente->find('first', array('recursive' => -1, 'fields' => array('Cliente.nombre', 'Cliente.direccion'), 'conditions' => array('Cliente.id' => $idCliente)));

        if ($this->RequestHandler->responseType() == 'json') {
            $this->paginate = array(
                'fields' => array('Chip.id', 'Chip.cantidad', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha'),
                'recursive' => 0,
                'order' => 'Chip.created'
                , 'conditions' => array('Chip.distribuidor_id' => $this->Session->read('Auth.User.id'), 'Chip.cliente_id' => NULL)
            );
            $this->DataTable->fields = array('Chip.id', 'Chip.cantidad', 'Chip.cantidad', 'Chip.sim', 'Chip.imsi', 'Chip.telefono', 'Chip.fecha');
            $this->DataTable->emptyEleget_usuarios_adminments = 1;
            $this->set('chips', $this->DataTable->getResponse('Ventasdistribuidor', 'Chip'));
            $this->set('_serialize', 'chips');
        }
        $this->set(compact('cliente', 'idCliente'));
    }

    public function registra_asignado() {
        $datos = $this->request->data['Dato'];
        if (!empty($datos['rango_ini']) && !empty($datos['cantidad'])) {
            $chips = $this->Chip->find('all', array(
                'recursive' => -1,
                'order' => 'Chip.id', 'limit' => $datos['cantidad'], 'fields' => array('Chip.id'),
                'conditions' => array('Chip.id >=' => $datos['rango_ini'], 'Chip.cliente_id' => NULL, 'Chip.distribuidor_id' => $this->Session->read('Auth.User.id'))
            ));
            foreach ($chips as $ch) {
                $this->Chip->id = $ch['Chip']['id'];
                $dato['Chip']['cliente_id'] = $datos['cliente_id'];
                $dato['Chip']['fecha_entrega_c'] = date('Y-m-d');
                $this->Chip->save($dato['Chip']);
            }
            $this->Session->setFlash('Se asigno correctamente', 'msgbueno');
        } else {
            $this->Session->setFlash('No se pudo registrar', 'msgerror');
        }
        $this->redirect(array('action' => 'chips', $datos['cliente_id']));
    }

    public function reporte_detallado_precio() {
        $fecha_ini = $this->request->data['Dato']['fecha_ini'];
        $fecha_fin = $this->request->data['Dato']['fecha_fin'];
        $persona = $this->Session->read('Auth.User.persona_id');
        $datos = array();
        $recargas = array();
        if (!empty($this->request->data['Dato'])) {
            $sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM totales mo WHERE mo.persona_id = $persona AND Producto.id = mo.producto_id LIMIT 1)";
            $sql2 = "(SELECT CONCAT(SUM(mov.ingreso)+SUM(mov.salida)) FROM movimientos mov WHERE mov.persona_id = $persona AND mov.created > '$fecha_fin' AND Producto.id = mov.producto_id GROUP BY mov.producto_id)";
            //$sql1 = "(SELECT IF(ISNULL(mo.total),0,mo.total) FROM movimientos mo WHERE mo.persona_id = $persona AND mo.created >= '$fecha_ini' AND mo.created <= '$fecha_fin' AND Producto.id = mo.producto_id ORDER BY mo.id DESC LIMIT 1)";
            $this->Movimiento->virtualFields = array(
                'total_s' => "CONCAT($sql1-(IF(ISNULL($sql2),0,$sql2)))"
            );
            $datos = $this->Movimiento->find('all', array(
                'recursive' => 0, 'order' => 'Movimiento.producto_id',
                'conditions' => array('Movimiento.persona_id' => $persona, 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.salida !=' => NULL),
                'group' => array('Movimiento.producto_id'),
                'fields' => array('Producto.nombre', 'SUM(Movimiento.ingreso) entregado', 'Producto.id', 'Movimiento.total_s')
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
            $recargas = $this->Recargado->find('all', array(
                'conditions' => array('Recargado.user_id' => $this->Session->read('Auth.User.id'), 'DATE(Recargado.created) >=' => $fecha_ini, 'DATE(Recargado.created) <=' => $fecha_fin)
            ));
        }
        $this->set(compact('datos', 'recargas'));
    }

    public function reporte_cliente() {
        $fecha_ini = $this->request->data['Dato']['fecha_ini'];
        $fecha_fin = $this->request->data['Dato']['fecha_fin'];
        $persona = $this->Session->read('Auth.User.persona_id');
        $datos = array();
        if (!empty($this->request->data['Dato'])) {
            $datos = $this->Movimiento->find('all', array(
                'recursive' => 0, 'order' => 'Movimiento.producto_id',
                'conditions' => array('Movimiento.persona_id' => $persona, 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.salida !=' => NULL, 'Movimiento.cliente_id !=' => NULL),
                'group' => array('Movimiento.cliente_id'),
                'fields' => array('Cliente.nombre', 'Cliente.num_registro', 'Movimiento.cliente_id', 'SUM(Movimiento.salida) ventas', 'SUM(Movimiento.precio_uni*Movimiento.salida)')
            ));
            foreach ($datos as $key => $da) {
                $datos_aux = $this->Movimiento->find('all', array(
                    'recursive' => 0, 'order' => 'Movimiento.producto_id',
                    'conditions' => array('Movimiento.persona_id' => $persona, 'Movimiento.created >=' => $fecha_ini, 'Movimiento.created <=' => $fecha_fin, 'Movimiento.precio_uni !=' => NULL, 'Movimiento.cliente_id' => $da['Movimiento']['cliente_id'], 'Movimiento.salida !=' => 'null'),
                    'group' => array('Movimiento.producto_id', 'Movimiento.precio_uni'),
                    'fields' => array('Producto.nombre', 'SUM(Movimiento.salida) vendidos', 'Movimiento.precio_uni', '(Movimiento.precio_uni*SUM(Movimiento.salida)) precio_total')
                ));
                $datos[$key]['productos'] = $datos_aux;
            }
            //debug($datos);exit;
        }
        $this->set(compact('datos'));
    }

    public function entregados() {
        $entregados = $this->Chip->find('all', array(
            'fields' => array('Chip.fecha_entrega_c', 'Cliente.nombre', 'Cliente.id', 'Cliente.num_registro', 'COUNT(*) as num_chips', 'Chip.pagado', 'Chip.precio_d', 'Chip.excel_id')
            , 'conditions' => array('Chip.distribuidor_id' => $this->Session->read('Auth.User.id'), 'Chip.cliente_id !=' => NULL, 'Chip.fecha_entrega_c !=' => NULL)
            , 'group' => array('Chip.fecha_entrega_c', 'cliente_id')
            , 'order' => 'fecha_entrega_d DESC'
            , 'LIMIT' => 50
        ));
        $precio_chip = $this->Precio->findByid(3);
        $this->set(compact('entregados', 'precio_chip'));
    }

    public function modifica_entregas() {
        $this->layout = 'ajax';
    }

    public function cancela_entrega($fecha = null, $idCliente = null) {
        $entregas = $this->Chip->find('all', array(
            'fields' => array('Chip.id'),
            'conditions' => array('Chip.fecha_entrega_c' => $fecha, 'Chip.cliente_id' => $idCliente)
        ));
        foreach ($entregas as $en) {
            $this->Chip->id = $en['Chip']['id'];
            $dchip['cliente_id'] = NULL;
            $this->Chip->save($dchip);
        }
        $this->Session->setFlash('Se cancelo correctamente!!!', 'msgbueno');
        $this->redirect($this->referer());
    }

    public function detalle_entrega($idCliente = null, $idExcel = null) {        
        $cliente = $this->Cliente->findByid($idCliente, null, null, -1);
        $entregados = $this->Chip->find('all', array(
            'recursive' => -1,
            'conditions' => array('Chip.excel_id' => $idExcel, 'Chip.cliente_id' => $idCliente)
        ));
        $this->set(compact('entregados', 'fecha', 'cliente'));
    }

    public function cancela_entrega_id($idChip = null) {
        $this->Chip->id = $idChip;
        $dchip['cliente_id'] = null;
        $this->Chip->save($dchip);
        $this->Session->setFlash('Se cancelo correctamente!!!', 'msgbueno');
        $this->redirect($this->referer());
    }

    public function pedido($numero = null) {
        $this->Session->read('Auth.User.id');
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
        }
        /* debug($pedidos_i);
          exit; */
        $this->set(compact('productos', 'pedidos_c', 'pedidos_i', 'ultimo_pedido'));
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
                $dape['distribuidor_id'] = $this->Session->read('Auth.User.id');
                $this->Pedido->create();
                $this->Pedido->save($dape);
            }
        }
        $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
        $this->redirect(array('action' => 'lista_pedidos'));
    }

    public function lista_pedidos() {
        $pedidos = $this->Pedido->find('all', array(
            'conditions' => array('Pedido.distribuidor_id' => $this->Session->read('Auth.User.id')),
            'group' => array('Pedido.numero'),
            'limit' => 50,
            'order' => 'Pedido.numero DESC'
        ));
        $this->set(compact('pedidos'));
    }

    public function cancela_asignado() {
        //debug($this->request->data);
        $idDis = $this->Session->read('Auth.User.id');
        if (!empty($this->request->data['Dato'])) {
            $rango_ini = $this->request->data['Dato']['rango_ini'];
            $cantidad = $this->request->data['Dato']['cantidad'];
            $idDistribuidor = $idDis;
            $fecha_d = $this->request->data['Dato']['fecha'];
            $chips = $this->Chip->find('all', array(
                'recursive' => -1,
                'order' => 'Chip.id', 'limit' => $cantidad, 'fields' => array('Chip.id'),
                'conditions' => array('Chip.id >=' => $rango_ini, 'Chip.distribuidor_id' => $idDistribuidor, 'Chip.cliente_id !=' => NULL, 'Chip.fecha_entrega_d' => $fecha_d)
            ));
            //debug($chips);
            // exit; 
            foreach ($chips as $ch) {
                $this->Chip->id = $ch['Chip']['id'];
                $dato['Chip']['fecha_entrega_d'] = date('Y-m-d');
                $dato['Chip']['cliente_id'] = NULL;
                $this->Chip->save($dato['Chip']);
            }
            $this->Session->setFlash('Se cancela correctamente', 'msgbueno');
        } else {
            $this->Session->setFlash('No se pudo cancelar!!', 'msgerror');
        }
        $this->redirect($this->referer());
    }

    public function get_num_trans() {
        $ultimo = $this->Movimiento->find('first', array(
            'order' => 'Movimiento.id DESC',
            'recursive' => -1,
            'fields' => array('Movimiento.transaccion')
        ));
        if (!empty($ultimo)) {
            return $ultimo['Movimiento']['transaccion'] + 1;
        } else {
            return 1;
        }
    }

    public function set_total($idProducto = null, $es_almacen = null, $id = null, $total = null) {
        $condiciones = array();
        $condiciones['Totale.producto_id'] = $idProducto;
        if ($es_almacen == 1) {
            $condiciones['Totale.almacene_id'] = $id;
            $datos_t['almacene_id'] = $id;
        } else {
            $condiciones['Totale.persona_id'] = $id;
            $datos_t['persona_id'] = $id;
        }
        $dato_total = $this->Totale->find('first', array(
            'recursive' => -1,
            'conditions' => $condiciones,
            'fields' => array('Totale.id')
        ));
        if (!empty($dato_total)) {
            $this->Totale->id = $dato_total['Totale']['id'];
        } else {
            $this->Totale->create();
        }
        $datos_t['producto_id'] = $idProducto;
        $datos_t['total'] = $total;
        $this->Totale->save($datos_t);
    }

    public function get_total($idProducto = null, $es_almacen = null, $id = null) {
        $condiciones = array();
        $condiciones['Totale.producto_id'] = $idProducto;
        if ($es_almacen == 1) {
            $condiciones['Totale.almacene_id'] = $id;
        } else {
            $condiciones['Totale.persona_id'] = $id;
        }
        $dato_total = $this->Totale->find('first', array(
            'recursive' => -1,
            'conditions' => $condiciones,
            'fields' => array('Totale.total')
        ));
        if (!empty($dato_total)) {
            return $dato_total['Totale']['total'];
        } else {
            return 0;
        }
    }

    public function ventas() {
        $ventas = $this->Movimiento->find('all', array(
            'conditions' => array('Movimiento.created' => date("Y-m-d"), 'Movimiento.persona_id' => $this->Session->read('Auth.User.persona_id'), 'Movimiento.salida !=' => 0),
            'group' => array('Movimiento.transaccion'),
            'fields' => array('Cliente.nombre', 'SUM(Movimiento.precio_uni*Movimiento.salida) as monto_total', 'Movimiento.transaccion', 'Movimiento.cliente_id')
        ));
        //debug($ventas);exit;
        $this->set(compact('ventas'));
    }

    public function get_d_edit_v($num_trans = null, $idProducto = null, $precio = null) {
        $movimiento = $this->Movimiento->find('first', array(
            'recursive' => -1,
            'conditions' => array('Movimiento.transaccion' => $num_trans, 'Movimiento.producto_id' => $idProducto, 'Movimiento.precio_uni' => $precio, 'Movimiento.created' => date("Y-m-d")),
            'fields' => array('Movimiento.id', 'Movimiento.salida')
        ));
        if (!empty($movimiento)) {
            return $movimiento['Movimiento'];
        } else {
            return NULL;
        }
    }

    public function eliminar_pedido($NumPedido = null) {
        $this->Pedido->deleteAll(array('Pedido.numero' => $NumPedido));
        $this->Session->setFlash("Se elimino correctamente el pedido!!", 'msgbueno');
        $this->redirect($this->referer());
    }

    public function cliente($idCliente = null) {
        $this->Cliente->id = $idCliente;
        $this->request->data = $this->Cliente->read();
        $lugares = $this->Lugare->find('list', array('fields' => 'nombre'));
        $rutas = $this->Ruta->find('list', array('fields' => 'nombre'));
        $this->set(compact('lugares', 'rutas'));
    }

    public function registra_cliente() {
        if (!empty($this->request->data['Cliente'])) {
            $this->request->data['Cliente']['estado'] = 1;
            $this->Cliente->create();
            $this->Cliente->save($this->request->data['Cliente']);
            $this->Session->setFlash("Se registro correctamente!!", 'msgbueno');
        } else {
            $this->Session->setFlash("No se pudo registrar!!", 'msgerror');
        }
        $this->redirect(array('action' => 'clientes'));
    }

    public function asignados() {
        $entregados = $this->Chip->find('all', array(
            'fields' => array('Chip.fecha_entrega_d', 'Chip.distribuidor_id', 'COUNT(*) as num_chips', 'Chip.pagado', 'Chip.precio_d')
            , 'recursive' => 0
            , 'conditions' => array('Chip.distribuidor_id' => $this->Session->read('Auth.User.id'))
            , 'group' => array('Chip.fecha_entrega_d')
            , 'order' => 'fecha_entrega_d DESC'
            , 'LIMIT' => 50
        ));
        //debug($entregados);exit;
        $precio_chip = $this->Precio->findByid(3);
        /* debug($precio_chip);exit; */
        $this->set(compact('entregados', 'excel', 'precio_chip'));
    }

    public function detalle_asignados($fecha = null) {
        $entregados = $this->Chip->find('all', array(
            'recursive' => -1,
            'conditions' => array('Chip.fecha_entrega_d' => $fecha, 'Chip.distribuidor_id' => $this->Session->read('Auth.User.id'))
        ));
        $this->set(compact('entregados', 'fecha'));
    }

    public function mismetas() {
        $idUser = $this->Session->read('Auth.User.id');
        $rutas = $this->Rutasusuario->find('list', array(
            'recursive' => -1,
            'conditions' => array('Rutasusuario.user_id' => $idUser),
            'fields' => array('Rutasusuario.id', 'Rutasusuario.ruta_id')
        ));
        $ano = date('Y');
        $mes = date('m');
        $sql1 = "(SELECT COUNT(activados.id) FROM activados WHERE YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";
        //$sql2 = "(SELECT COUNT(activados.id) FROM activados WHERE YEAR(activados.fecha_act) = $ano AND MONTH(activados.fecha_act) = $mes AND LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1) = Ruta.cod_ruta AND activados.comercial LIKE 'SI' GROUP BY LEFT(activados.canal_n,LOCATE('-',activados.canal_n) - 1))";

        $this->Meta->virtualFields = array(
            'ventas' => "($sql1)",
            //'comercial' => "$sql2"
        );
        
        $metas = $this->Meta->find('all', array(
            'recursive' => 0,
            'conditions' => array('Meta.anyo' => $ano, 'Meta.mes' => $mes,'Meta.ruta_id' => $rutas)
        ));
        $this->set(compact('metas','ano','mes'));
    }

}

?>