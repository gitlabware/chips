<?php

class GroupsController extends AppController
{
    public $uses = array('Group');
    public $layout = 'viva';

	public function beforeFilter()
    {
        parent::beforeFilter();
        //$this->Auth->allow();
    }
    public function index()
    {
        $groups = $this->Group->find('all');
        $this->set(compact('groups'));
    }

   function insertar(){
        if(!empty($this->data)){
            if($this->Group->save($this->data)){
                $this->Session->setFlash('Se Guardo Correctamente!!!');
                $this->redirect(array('action'=>'index')); 
            }
            else{
                $this->Session->setFlash('Error al Guardar consulte con el Administrador de Sistema');
            }
        }
        
    }

    public function editar($id = null)
    {
        $this->Group->id = $id;
        if (!$id) {
            $this->Session->setFlash('No existe tal registro');
            $this->redirect(array('action' => 'index'), null, true);
        }
        if (empty($this->data)) {
            $this->data = $this->Group->read();
        } else {
            if ($this->Group->save($this->data)) {
                $this->Session->setFlash('Los datos fueron modificados');
                $this->redirect(array('action' => 'index'), null, true);
            } else {
                $this->Session->setFlash('no se pudo modificar!!');
            }
        }
    }

    public function eliminar($id = null)
    {
        if (!$id) {
            $this->Session->setFlash('id Invalida para borrar');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Group->delete($id)) {
            $this->Session->setFlash('El Group  ' . $id . ' fue borrado');
            $this->redirect(array('action' => 'index'));
        }
    }

}

?>
