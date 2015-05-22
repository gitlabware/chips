<?php

class LugaresController extends AppController {

    public $layout = 'viva';
    public $uses = array('Lugare');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    public function index (){
        $this->paginate=array('Lugare'=>array('limit'=>100));
        $this->set('lugares', $this->paginate('Lugare'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Lugare->create();
            if ($this->Lugare->save($this->request->data)) {
                $this->Session->setFlash('Registrado Correctamente', 'msgbueno');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Error el registrar!', 'msgerror');
            }
        }
    }
    
    public function edit($id = null) {
        $this->Lugare->id = $id;
        if (!$this->Lugare->exists()) {
            throw new NotFoundException(__('Invalido'));
        }
        if ($this->request->is(array('post', 'put'))) {

            if ($this->Lugare->save($this->request->data)) {
                $this->Session->setFlash('Registro exitoso', 'msgbueno');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Error al registrar', 'msgerror');
            }
        } else {
            $this->request->data = $this->Lugare->read(null, $id);
        }
    }

    public function delete($id = null) {
        $this->Lugare->id = $id;
        if (!$this->Lugare->exists()) {
            throw new NotFoundException(__('Categoria invalido'));
        }
        if ($this->Lugare->delete()) {
            $this->Session->setFlash(__('Eliminado!!'), 'msgbueno');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('No se elemino'), 'msgalert');
        $this->redirect(array('action' => 'index'));
    }
}
