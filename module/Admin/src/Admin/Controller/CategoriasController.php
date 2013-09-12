<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;
use Zend\View\Model\ViewModel;

/**
 * Controller que gerencia os categorias
 * @package Admin
 * @group Controller
 * @author Eu <eu@eu.com>
 * 
 */
class CategoriasController extends CoreController {

    public function indexAction() {
        
        $form = new \Admin\Form\Busca();
        $autor = $this->getTable('\Admin\Model\Categoria');
        $sql = $autor->getSql();
        $select = $sql->select();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $busca = mb_strtoupper($request->getPost('busca'), 'UTF-8');
            $select->where->like('nome', "%$busca%");
        }
        $paginatorAdapter = new PaginatorDbSelectAdapter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        return new ViewModel(array(
            'categorias' => $paginator,
            'form' => $form
        ));
    }

    public function saveAction() {
        $request = $this->getRequest();
        $form = new \Admin\Form\Descricao();

        if ($request->isPost()) {
            $values = $request->getPost();
            unset($values['submit']);
            $Categoria = new \Admin\Model\Categoria();
            $form->setInputFilter($Categoria->getInputFilter());
            $form->setData($values);
            if ($form->isValid()) {
                $values = $form->getData();
                $Categoria->setData($values);
                try {

                    $this->getTable('\Admin\Model\Categoria')->save($Categoria);

                    return $this->redirect()->toUrl('/admin/categorias');
                } catch (\Exception $e) {
                    echo $e;
                    exit;
                }
            }
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id > 0) {
            $dados = $this->getTable('\Admin\Model\Categoria')->get($id);

            $form->bind($dados);
        }

        return new ViewModel(array(
            'form' => $form)
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $id = $this->getTable('\Admin\Model\Categoria')->delete($id);
            return $this->redirect()->toUrl('/admin/categorias');
        }
        die('Passe o Id');
    }

}
