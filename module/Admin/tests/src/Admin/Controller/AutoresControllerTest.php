<?php

use Core\Test\ControllerTestCase;
use Admin\Controller\AutoresController;
use Admin\Model\Autor;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Renderer\PhpRenderer;


/**
* @group Controller
*/
class AutoresControllerTest extends ControllerTestCase
{
        /**
        * Namespace completa do Controller
        * @var string
        */
        protected $controllerFQDN = 'Admin\Controller\AutoresController';

        /**
        * Nome da rota. Geralmente o nome do módulo
        * @var string
        */
        protected $controllerRoute = 'admin';

        /**
        * Testa o acesso a uma action que não existe
        */
        public function test404()
        {
            $this->routeMatch->setParam('action', 'action_nao_existente');
            $result = $this->controller->dispatch($this->request);
            $response = $this->controller->getResponse();
            $this->assertEquals(404, $response->getStatusCode());
        }

        public function testIndexAction()
        {
            // Cria autores para testar
            $Autor1 = $this->addAutor();
            $Autor2 = $this->addAutor();

            // Invoca a rota index
            $this->routeMatch->setParam('action', 'index');
            $result = $this->controller->dispatch($this->request, $this->response);

            // Verifica o response
            $response = $this->controller->getResponse();
            $this->assertEquals(200, $response->getStatusCode());

            // Testa se um ViewModel foi retornado
            $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

            // Testa os dados da view
            $variables = $result->getVariables();

            $this->assertArrayHasKey('autores', $variables);

            // Faz a comparação dos dados
            $controllerData = $variables["autores"]->getCurrentItems()->toArray();
            $this->assertEquals($Autor1->nome, $controllerData[0]['nome']);
            $this->assertEquals($Autor2->nome, $controllerData[1]['nome']);
        } 


         /**
        * Testa a tela de inclusão de um novo registro
        * @return void
        */
         public function testSaveActionNewRequest()
         {

        // Dispara a ação
            $this->routeMatch->setParam('action', 'save');
            $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
            $response = $this->controller->getResponse();
            $this->assertEquals(200, $response->getStatusCode());
        // Testa se recebeu um ViewModel
            $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

        //verifica se existe um form
            $variables = $result->getVariables();
            $this->assertInstanceOf('Zend\Form\Form', $variables['form']);
            $form = $variables['form'];
        //testa os ítens do formulário
            $id = $form->get('id');
            
            $this->assertEquals('id', $id->getName());
            $this->assertEquals('hidden', $id->getAttribute('type'));
            $nome = $form->get('nome');
            $this->assertEquals('nome', $nome->getName());
            $this->assertEquals('text', $nome->getAttribute('type'));
        }


         /**
        * Testa a inclusão de um novo autor
        */
         public function testSaveActionPostRequest()
         {
        // Dispara a ação
            $this->routeMatch->setParam('action', 'save');
            $this->request->setMethod('post');
            $this->request->getPost()->set('nome', 'Maria');
            $this->request->getPost()->set('sobrenome', 'Santos');
            $this->request->getPost()->set('submit', 'submit');
            $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
            $response = $this->controller->getResponse();
        //a página redireciona, então o status = 302
            $this->assertEquals(302, $response->getStatusCode());

        //verifica se salvou
            $autores = $this->getTable('Admin\Model\Autor')->fetchAll()->toArray();
            $this->assertEquals(1, count($autores));
            $this->assertEquals('MARIA', $autores[0]['nome']);
            $this->assertNotNull($autores[0]['sobrenome']);
        }


         /**
        * Testa a alteração de um autor
        */
         public function testSaveActionUpdateFormRequest()
         {
            $Autor1 = $this->addAutor();

        // Dispara a ação
            $this->routeMatch->setParam('action', 'save');
            $this->routeMatch->setParam('id', $Autor1->id);
            $result = $this->controller->dispatch($this->request, $this->response);

        // Verifica a resposta
            $response = $this->controller->getResponse();
            $this->assertEquals(200, $response->getStatusCode());

        // Testa se recebeu um ViewModel
            $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

            $variables = $result->getVariables();

        //verifica se existe um form
            $variables = $result->getVariables();
            $this->assertInstanceOf('Zend\Form\Form', $variables['form']);
            $form = $variables['form'];

        //testa os ítens do formulário
            $id = $form->get('id');
            $nome = $form->get('nome');
            $sobrenome = $form->get('sobrenome');
            $this->assertEquals('id', $id->getName());
            $this->assertEquals($Autor1->id, $id->getValue());
            $this->assertEquals($Autor1->nome, $nome->getValue());
            $this->assertEquals($Autor1->sobrenome, $sobrenome->getValue());
        }

         /**
        * Tenta salvar com dados inválidos
        *
        */
         public function testSaveActionInvalidPostRequest()
         {
        // Dispara a ação
            $this->routeMatch->setParam('action', 'save');
            $this->request->setMethod('post');
            $this->request->getPost()->set('nome', '');
            $this->request->getPost()->set('sobrenome', '');
            $this->request->getPost()->set('submit', 'submit');
            $result = $this->controller->dispatch($this->request, $this->response);

        //verifica se existe um form
            $variables = $result->getVariables();
            $this->assertInstanceOf('Zend\Form\Form', $variables['form']);
            $form = $variables['form'];

        //testa os errors do formulário
            $nome = $form->get('nome');
            $nomeErrors = $nome->getMessages();
            $this->assertEquals("Value is required and can't be empty", $nomeErrors['isEmpty']);

            $sobrenome = $form->get('sobrenome');
            $sobrenomeErrors = $sobrenome->getMessages();
            $this->assertEquals("Value is required and can't be empty", $sobrenomeErrors['isEmpty']);
        }

         /**
        * Testa a exclusão sem passar o id do autor
        * @expectedException \Exception
        * @expectedExceptionMessage Passe o Id
        */
         public function testInvalidDeleteAction()
         {
            $Autor1 = $this->addAutor();
        // Dispara a ação
            $this->routeMatch->setParam('action', 'delete');

            $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
            $response = $this->controller->getResponse();

        }

         /**
        * Testa a exclusão do autor
        */
         public function testDeleteAction()
         {
            $Autor1 = $this->addAutor();
        // Dispara a ação
            $this->routeMatch->setParam('action', 'delete');
            $this->routeMatch->setParam('id', $Autor1->id);

            $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
            $response = $this->controller->getResponse();
        //a página redireciona, então o status = 302
            $this->assertEquals(302, $response->getStatusCode());

        //verifica se excluiu
            $autores = $this->getTable('Admin\Model\Autor')->fetchAll()->toArray();
            $this->assertEquals(0, count($autores));
        }


        private function addAutor()
        {
            $tableGateway = $this->getTable('Admin\Model\Autor');
            $Autor = new Autor();
            $Autor->nome = 'Pedro';
            $Autor->sobrenome = 'Silva';
            $saved = $tableGateway->save($Autor);

            return $saved;
        }




    }


