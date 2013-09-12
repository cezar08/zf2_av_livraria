<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;
use Zend\View\Model\ViewModel;

/**
 * Controller que gerencia os autores
 * @package Admin
 * @group Controller
 * @author Eu <eu@eu.com>
 * 
 */
class AutoresController extends CoreController {

    public function indexAction() {
        
        $form = new \Admin\Form\Busca();
        
        $autor = $this->getTable('\Admin\Model\Autor');
        
        //Para fazer a paginação dinamica precisamos de um objeto select e um sql
        $sql = $autor->getSql();
        
        $select = $sql->select();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $busca = mb_strtoupper($request->getPost('busca'), 'UTF-8');
            $select->where->like('nome', "%$busca%");
        }

        $cache = $this->getServiceLocator()->get('Cache');
        $paginatorAdapter = new PaginatorDbSelectAdapter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        //Itens por página
        $paginator->setItemCountPerPage(5);
        $paginator->setCache($cache);
        
        //A página corrente
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        
        return new ViewModel(array(
            'autores' => $paginator,
            'form' => $form
        ));
    }

    public function saveAction() {
        $request = $this->getRequest();
        $form = new \Admin\Form\Autor();

        if ($request->isPost()) {
            $values = $request->getPost();
            unset($values['submit']);
            $Autor = new \Admin\Model\Autor();
            $form->setInputFilter($Autor->getInputFilter());
            $form->setData($values);
            if ($form->isValid()) {
                $values = $form->getData();
                $Autor->setData($values);
                try {

                    $this->getTable('\Admin\Model\Autor')->save($Autor);

                    return $this->redirect()->toUrl('/admin/autores');
                } catch (\Exception $e) {
                    echo $e;
                    exit;
                }
            }
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id > 0) {
            $dados = $this->getTable('\Admin\Model\Autor')->get($id);

            $form->bind($dados);
        }

        return new ViewModel(array(
            'form' => $form)
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $id = $this->getTable('\Admin\Model\Autor')->delete($id);
            return $this->redirect()->toUrl('/admin/autores');
        }
        die('Passe o Id');
    }

}
