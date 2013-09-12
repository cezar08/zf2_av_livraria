<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

/**
 * Controller que gerencia os usuários
 * @package Admin
 * @group Controller
 * @author Eu <eu@eu.com>
 * 
 */
class UsuariosController extends CoreController {

    public function indexAction() {  
        $usuarios = $this->getTable('\Admin\Model\Usuario')->fetchAll()->toArray();  
        return new ViewModel(array(
            'usuarios' => $usuarios,
      
        ));
    }

    public function addAction() {
        $request = $this->getRequest();
        $form = new \Admin\Form\Usuario();
    
        if ($request->isPost()) {
            $values = $request->getPost();          
            unset($values['submit']);
            $Usuario = new \Admin\Model\Usuario();
            $values['senha'] = md5($values['senha']);
            $Usuario->setData($values);
            $id = $this->getTable('\Admin\Model\Usuario')->save($Usuario);            
            if (!$id)
                die('Erro');
            else {
                return $this->redirect()->toUrl('/admin/usuarios');
            }
        }

        return new ViewModel(array(
            'form' => $form)
        );
    }

    public function updateAction() {
        $id = $this->params()->fromRoute('id', 0);
        
        if ($id > 0) {
            $form = new \Admin\Form\Usuario();
            $request = $this->getRequest();
            $dadosUsuario = $this->getTable('\Admin\Model\Usuario')->get($id);
        if ($request->isPost()) {
            $values = $request->getPost();
           
            unset($values['submit']);
            $Usuario = new \Admin\Model\Usuario();
            $Usuario->setData($values);
            $id = $this->getTable('\Admin\Model\Usuario')->save($Usuario);
            
            if (!$id)
                die('Erro');
            else {
                return $this->redirect()->toUrl('/admin/usuarios');
            }
        }
            
            
            $form->populateValues($dadosUsuario->toArray());
            return new ViewModel(array('form' => $form));
        } else {
            die("Passe um Id");
        }
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {            
            $id = $this->getTable('\Admin\Model\Usuario')->delete($id);
            return $this->redirect()->toUrl('/admin/usuarios');
        }
        die('Passe o Id');
    }

}
