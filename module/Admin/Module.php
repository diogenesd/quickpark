<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Service\ViewHelperManagerFactory;
use Zend\Authentication\AuthenticationService;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        
        $eventManager->attach (
            MvcEvent::EVENT_ROUTE,
            function  (MvcEvent $e)
            {
                $serviceManager = $e->getApplication()->getServiceManager();
                $authenticationService = $serviceManager->get('Zend\Authentication\AuthenticationService');
                $loggedUser = $authenticationService->getIdentity();
                // update 
                $layout = $e->getViewModel();
                $layout->userinfo = $loggedUser;
       });
       
       
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig(){
        
        return array(
            
        );
    }
    
}
