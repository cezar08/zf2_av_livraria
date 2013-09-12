<?php

namespace Admin;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    ),
                ),
            );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(

                'DbAdapter' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                    return $dbAdapter;
                },
                'Core\Service\Auth' => function($sm) {
                    $dbAdapter = $sm->get('DbAdapter');
                    return new \Core\Service\Auth($dbAdapter);
                },
                'Core\Acl\Builder' => function($sm){
                    return new \Core\Acl\Builder;
                },
                'Session' => function($sm){                    
                    return new \Zend\Session\Container('Session');
                },
                'Cache' => function ($sm) {
                    // incluindo o arquivo config para pegar o cache adapter
                    $config = include __DIR__ . '/../../config/application.config.php';
                    $cache = \Zend\Cache\StorageFactory::factory(array(
                        'adapter' => array(
                            'name' => $config['cache']['adapter'],
                            'options' => array(
                            // tempo de validade do cache
                                'ttl' => 30,
                            // adicionando o diretorio data/cache para salvar os caches.
                                'cacheDir' => __DIR__ . '/../../data/cache'
                                ),
                            ),
                        'plugins' => array(
                            'exception_handler' => array('throw_exceptions' => false),
                            'Serializer'
                            )
                        ));
                    return $cache;
                } 
                
                ),
);
}

    /**
* Executada no bootstrap do módulo
*
* @param MvcEvent $e
*/
public function onBootstrap($e)
{
    /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
    $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
    /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
    $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
    if(!$e->getApplication()->getServiceManager()->get('Session')->offsetGet('language'))
        $language = 'en_US';
    else
        $language = $e->getApplication()->getServiceManager()->get('Session')->offsetGet('language');
    
    $e->getApplication()->getServiceManager()->get('translator')->setLocale($language); 

//adiciona eventos ao módulo
    $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
}

 /**
* Verifica se precisa fazer a autorização do acesso
* @param MvcEvent $event Evento
* @return boolean
*/
public function mvcPreDispatch($event)
{
    $di = $event->getTarget()->getServiceLocator();
    $routeMatch = $event->getRouteMatch();
    $moduleName = $routeMatch->getParam('module');
    $controllerName = $routeMatch->getParam('controller');
    $actionName = $routeMatch->getParam('action');


    $authService = $di->get('Core\Service\Auth'); 
    if (! $authService->authorize($moduleName, $controllerName, $actionName)) {
        throw new \Exception('Você não tem permissão para acessar este recurso');
    }
    return true;
}

}
