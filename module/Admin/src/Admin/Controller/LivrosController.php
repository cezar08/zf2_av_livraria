<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;
use Zend\View\Model\ViewModel;

/**
 * Controller que gerencia os livros
 * @package Admin
 * @group Controller
 * @author Eu <eu@eu.com>
 * 
 */
class LivrosController extends CoreController {

    public function indexAction() {
        $session = $this->getServiceLocator()->get('Session');



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
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        return new ViewModel(array(
            'livros' => $paginator,
            'form' => $form
        ));
    }

    public function saveAction() {
        $request = $this->getRequest();

        $categorias = $this->getTable('\Admin\Model\Categoria')
                        ->fetchAll(null, null, 'descricao ASC')->toArray();
        $idiomas = $this->getTable('\Admin\Model\Idioma')->fetchAll(null, null, 'descricao ASC')->toArray();
        $editoras = $this
                        ->getTable('\Admin\Model\Editora')->fetchAll(null, null, 'nome ASC')->toArray();
        $autores = $this
                        ->getTable('\Admin\Model\Autor')->fetchAll(null, null, 'nome ASC')->toArray();
        $form = new \Admin\Form\Livro($categorias, $idiomas, $editoras, $autores);

        if ($request->isPost()) {

            $values = $request->getPost();

            $Livro = new \Admin\Model\Livro();
            $form->setInputFilter($Livro->getInputFilter());
            $form->setData($values);
            if ($form->isValid()) {
                $values = $form->getData();
                unset($values['submit']);
                $autores = $values['autores']; //adiciona os autores a uma variável auxiliar

                unset($values['autores']);
                $Livro->setData($values);

                try {

                    $id_livro = $this->getTable('\Admin\Model\Livro')->save($Livro); //Salva ou atualiza os dados da entidade livro
                } catch (\Exception $e) {
                    echo $e;
                    exit;
                }

                $AutorLivro = new \Admin\Model\AutorLivro();
                if ($values['id']) {

                    $autoresLivro = $this->getTable('\Admin\Model\AutorLivro')
                                    ->fetchAll(array('id_autor'), "id_livro = " . $values['id'])->toArray(); //No update pega todos os autores que possuem relação com o livro

                    if ($autoresLivro) {
                        $this->getTable('\Admin\Model\AutorLivro')
                                ->deleteBy('id_livro', $values['id']); //Deleta os autores que contém relacionamento com o livro
                    }
                }
                foreach ($autores as $autor) {
                    //salva o relacionamento com os autores selecionados no form com o livro
                    try {
                        $data = array('id_livro' => $id_livro->id, 'id_autor' => $autor);
                        $AutorLivro->setData($data);


                        $this->getTable('\Admin\Model\AutorLivro')->save($AutorLivro);
                    } catch (\Exception $e) {
                        echo $e;
                        exit;
                    }
                }

                $Email = $this->getServiceLocator()->get('Email');
                $texto = "Olá, foi adicionado um novo livro:
                    Livro: " . $values['titulo'];

                $from = 'Livraria';
                $to = array('email' => 'cezar08@unochapeco.edu.br', 'name' => 'Cezar');
                $title = "Novo livro";
                $Email->send($texto, $from, $to, $title);

                $this->flashMessenger()->addSuccessMessage('Livro cadastrado com sucesso');
                return $this->redirect()->toUrl('/admin/livros');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id > 0) {

            //Carrega os dados do livro para atualização
            $dados = $this->getTable('\Admin\Model\Livro')->get($id);
            $autoresLivro = $this->getTable('\Admin\Model\AutorLivro')->fetchAll(array('id_autor'), "id_livro = $id")->toArray();

            $form->bind($dados);

            $multiOptionSelected = array();
            foreach ($autoresLivro as $autorSelect) {
                $multiOptionSelected[$autorSelect['id_autor']] = $autorSelect['id_autor'];
            }

            $form->get('autores')->setValue($multiOptionSelected);
        }

        return new ViewModel(array(
            'form' => $form)
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $id = $this->getTable('\Admin\Model\Livro')->delete($id);
            return $this->redirect()->toUrl('/admin/livros');
        }
        die('Passe o Id');
    }

}
