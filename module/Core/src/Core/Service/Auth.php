<?php 
namespace Core\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Db\Sql\Select;
use Core\Service\Service;

/**
* 
*
* @category Core
* @package Service
* @author cezar<cezar08@unochapeco.edu.br>
*/
class Auth extends Service
{
/**
* 
* @var Zend\Db\Adapter\Adapter
*/
private $dbAdapter;


public function __construct($dbAdapter = null)
{
	$this->dbAdapter = $dbAdapter;
}

/**
* Faz a autenticação dos usuários
*
* @param array $params
* @return array
*/
public function authenticate($params)
{

	if (!isset($params['login']) || !isset($params['senha'])) {
		throw new \Exception("Parâmetros inválidos");
	}
	$password = md5($params['senha']);
	$auth = new AuthenticationService();
	$authAdapter = new AuthAdapter($this->dbAdapter);
	$authAdapter
	->setTableName('Usuario')
	->setIdentityColumn('login')
	->setCredentialColumn('senha')
	->setIdentity($params['login'])
	->setCredential($password);
	$result = $auth->authenticate($authAdapter);
	if (! $result->isValid()) {
		throw new \Exception("Login ou senha inválidos");
	}

//salva o usuário na sessão
	$session = $this->getServiceManager()->get('Session');
	$session->offsetSet('user', $authAdapter->getResultRowObject());

	return true;
}

/**
* Faz o logout do sistema
*
* @return void
*/
public function logout() {
	$auth = new AuthenticationService();
	$session = $this->getServiceManager()->get('Session');
	$session->offsetUnset('user');
	$auth->clearIdentity();
	return true;
}

/**
* Faz a autorização do usuário para acessar o recurso
* @param string $moduleName Nome do módulo sendo acessado
* @param string $controllerName Nome do controller
* @param string $actionName Nome da ação
* @return boolean
*/
public function authorize($moduleName, $controllerName, $actionName)
{
	$auth = new AuthenticationService();
	$perfil = 'Cliente';

	if ($auth->hasIdentity()) {

		$session = $this->getServiceManager()->get('Session');
		$user = $session->offsetGet('user');

		$perfil = $user->perfil;
	}
	
	$resource = $controllerName . '.' . $actionName;
	$acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();

	if ($acl->isAllowed($perfil, $resource)) {
		return true;
	}
	return false;
}

}