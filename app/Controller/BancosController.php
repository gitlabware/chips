<?php

class BancosController extends AppController {

    public $layout = 'viva';
    public $uses = 'Banco';

    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow();
    }

    public function index() {
        $this->paginate = array('Banco' => array('limit' => 100));
        $this->set('bancos', $this->paginate('Banco'));
    }
    
    public function add (){
        if($this->request->is('post')){
            $this->Banco->create();
            if($this->Banco->save($this->request->data)){
                $this->Session->setFlash('Banco registrado exitosamente','msgbueno');
                return $this->redirect(array('action'=>'index'));
            } else{
                $this->Session->setFlash('Error al Registrar!','msgerror');
                return $this->redirect(array('action'=>'add'));
            }
        }
    }
    
    public function edit($id=null){
        $this->Banco->id=$id;
        if(!$this->Banco->exists()){
            throw new NotFoundException(__('Invalido'));
        }
        if($this->request->is(array('post','put'))){
            if($this->Banco->save($this->request->data)){
                $this->Session->setFlash('Modificado correctamente','msgbueno');
                return $this->redirect(array('action'=>'index'));
            } else{
                $this->Session->setflash('No se modifico','msgerror');
            }
        } else {
            $this->request->data=  $this->Banco->read(null, $id);
        }
    }
    
    public function delete($id=null){
        $this->Banco->id=$id;
        if(!$this->Banco->exists()){
            throw new NotFoundException(__('Invalido'));
        }
        if($this->Banco->delete()){
            $this->Session->setFlash('Eliminacion correcta','msgbueno');
            return $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('No se elemino'), 'msgalert');
        $this->redirect(array('action' => 'index'));
    }

}
