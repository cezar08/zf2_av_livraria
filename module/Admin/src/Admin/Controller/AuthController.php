<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\CoreController;

/**
* Controlador que gerencia os posts
*
* @category Admin
* @package Controller
* @author Cezar<email@...>
*/
class AuthController extends CoreController
{

public function indexAction()
{
	$form = new \Admin\Form\Login();
	return new ViewModel(array(
		'form' => $form
		));
}


public function loginAction()
{
	$request = $this->getRequest();
	if (!$request->isPost()) {
		throw new \Exception('Acesso inválido');
	}

	$data = $request->getPost();
	$service = $this->getServiceLocator()->get('Core\Service\Auth');
	$auth = $service->authenticate(
		array('login' => $data['login'], 'senha' => $data['senha'])
		);
	return $this->redirect()->toUrl('/admin/livros');
}


public function logoutAction()
{
	$service = $this->getServiceLocator()->get('Core\Service\Auth');
	$auth = $service->logout();
	return $this->redirect()->toUrl('/admin/auth');
}
}