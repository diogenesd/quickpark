<?php
namespace Base;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $serviceManager = $e->getApplication()->getServiceManager();
        $serviceManager->get('doctrine.entitymanager.orm_default')
            ->getConfiguration()->setSQLLogger($serviceManager->get('FirePhpProfiler'));
        
        $config = $serviceManager->get('config');
        $config = $config['myConfiguration'];
        if($config['firephp']){
            $eventManager->attach(
                MvcEvent::EVENT_FINISH,
                function ($e) use ($serviceManager) {
                    $profiler = $serviceManager->get('FirePhpProfiler');
                    $profiler->showTable();
                },
                100
            );
        }
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
            'invokables' => array(
                'FirePhpProfiler' => 'Admin\Profiler\FirePhpProfiler',
            ),
        );
    }
}
