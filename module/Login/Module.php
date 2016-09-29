<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Login;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Login\Entity\WhitelistRepository;
use Zend\Authentication\AuthenticationService;
use Login\Model\Db\RoleTable;
use Login\Utility\Acl;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
                ), 100);
    }

    function boforeDispatch(MvcEvent $event) {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $target = $event->getTarget();

        $serviceManager = $event->getApplication()->getServiceManager();
        $authenticationService = $serviceManager->get('Zend\Authentication\AuthenticationService');


        $whiteList = $this->_getAllWhitelist($event);
        $controller = $event->getRouteMatch()->getParam('controller');
        $action = $event->getRouteMatch()->getParam('action');
        $requestedResourse = $controller . "-" . $action;
        if ($authenticationService->hasIdentity()) {
            if (!$requestedResourse == 'Login\Controller\Index-index' && !in_array($requestedResourse, $whiteList)) {

                $loggedUser = $authenticationService->getIdentity();

                $userRoles = $loggedUser->getRoles();
                $acl = $serviceManager->get('Acl');

                $acl->initAcl();

                $status = $acl->isAccessAllowed($userRoles, $controller, $action);
                if (!$status) {
                    $url = $event->getRouter()->assemble(array(), array('name' => 'permissiondenied'));
                    $response->setHeaders($response->getHeaders()
                                    ->addHeaderLine('Location', $url));
                    $response->setStatusCode(302);
                }
            }
        }
    }

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
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },
                'Acl' => function ($serviceManager) {
                    return new Acl();
                },
            ),
        );
    }

    protected function _getAllWhitelist($event) {
        $serviceManager = $event->getApplication()->getServiceManager();
        $em = $serviceManager->get('Doctrine\ORM\EntityManager');
        $lista = $em->getRepository('Login\Entity\Whitelist')->findBy(array('active' => 1));
        $retorno = array();
        foreach ($lista as $whitelist) {
            array_push($retorno, $whitelist->getWhiteListName());
        }

        return $retorno;
    }

}
