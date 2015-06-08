<?php

class TiposproductosController extends AppController {

    public $uses = array('Tiposproducto');
    var $components = array('RequestHandler', 'DataTable');
    public $layout = 'viva';

    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow();
    }

    public function index() {
        $this->paginate = array('Tiposproducto' => array('limit' => 100));
        $this->set('tiposproductos', $this->paginate('Tiposproducto'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Tiposproducto->create();
            if ($this->Tiposproducto->save($this->request->data)) {
                $this->Session->setFlash('Registrado Correctamente', 'msgbueno');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Error el registrar!', 'msgerror');
            }
        }
    }

    public function edit($id = null) {
        $this->Tiposproducto->id = $id;
        if (!$this->Tiposproducto->exists()) {
            throw new NotFoundException(__('Invalido Categoria'));
        }
        if ($this->request->is(array('post', 'put'))) {

            if ($this->Tiposproducto->save($this->request->data)) {
                $this->Session->setFlash('Registro exitoso', 'msgbueno');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Error al registrar', 'msgerror');
            }
        } else {
            $this->request->data = $this->Tiposproducto->read(null, $id);
        }
    }

    public function delete($id = null) {
        $this->Tiposproducto->id = $id;
        if (!$this->Tiposproducto->exists()) {
            throw new NotFoundException(__('Categoria invalido'));
        }
        if ($this->Tiposproducto->delete()) {
            $this->Session->setFlash(__('Categoria eliminada'), 'msgbueno');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('La categoria no se elemino'), 'msgalert');
        $this->redirect(array('action' => 'index'));
    }

}
