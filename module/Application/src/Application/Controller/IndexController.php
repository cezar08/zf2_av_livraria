<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Core\Controller\CoreController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;
use Zend\Db\Sql\Sql;
use Zend\View\Model\ViewModel;

class IndexController extends CoreController
{
    public function indexAction()
    {        

        $cache = $this->getServiceLocator()->get('Cache');
      /*Exemplo cache  
        $cache = $this->getServiceLocator()->get('Cache');

        $cache->addItem('teste', "adrusbal");
        var_dump($cache->getItem('teste')); exit;
        */

        $form = new \Admin\Form\Busca();
        $livro = $this->getTable('\Admin\Model\Livro');
        $sql = $livro->getSql();
        $select = $sql->select();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $busca = mb_strtoupper($request->getPost('busca'), 'UTF-8');
            $select->where->like('titulo', "%$busca%");
        }
               
        $paginatorAdapter = new PaginatorDbSelectAdapter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage(5);
        $paginator->setCache($cache);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        return new ViewModel(array(
            'livros' => $paginator,
            'form' => $form
            ));

    }

    public function livroAction(){
		
		
        $id = (int) $this->params()->fromRoute('id', 0);
        $adapter = $this->getServiceLocator()->get('DbAdapter');
        $sql = new Sql($adapter);
        $select = $sql->select();
        $select = $select
        ->from('Livro')->join(
            'Idioma',
            'Livro.id_idioma = Idioma.id',
            array('descricao'),
            $select::JOIN_INNER
            )->join(
            'Editora',
            'Livro.id_editora = Editora.id',
            array('nome_editora' => 'nome'),
            $select::JOIN_INNER
            )->join(
            'AutorLivro',
            'Livro.id = AutorLivro.id_livro',
            array('id_autor'),
            $select::JOIN_INNER
            )->join(
            'Autor',
            'Autor.id = AutorLivro.id_autor',
            array('nome_autor' => 'nome'),
            $select::JOIN_INNER
            )->where('Livro.id = '.$id);
            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();        
            $array = array_values(iterator_to_array($results));
            $result = new ViewModel(array(
                'autores' => $array
                )
            );
            $result->setTerminal(true);
            return $result;

        }

        public function idiomaAction(){
            $session = $this->getServiceLocator()->get('Session');
            $param = $this->params()->fromRoute('idioma');
            $session->offSetSet('language', $param);
            return $this->redirect()->toUrl('/');
        }
        
        public function noauthorizeAction(){
			die('sai dai');
		}


    }
