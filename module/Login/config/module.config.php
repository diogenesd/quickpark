<?php

namespace Login;

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /login/:controller/:action
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller' => 'Index',
                        'action' => 'logout'
                    )
                )
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Login\Controller\Index' => 'Login\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/login.phtml',
            'login/index/index' => __DIR__ . '/../view/login/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'TpMinify' => array(
        'serveOptions' => array(
            'minApp' => array(
                'groups' => array(
                    'login-css' => array(
                        getcwd() . '/public/css/styles.css',
                        getcwd() . '/public/libs/bootstrap/dist/css/bootstrap.min.css',
                        getcwd() . '/public/libs/metisMenu/dist/metisMenu.css',
                        getcwd() . '/public/libs/animate.css/animate.css',
                        getcwd() . '/public/libs/toastr/build/toastr.min.css',
                        getcwd() . '/public/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
                        getcwd() . '/public/fonts/pe-icon-7-stroke/css/helper.css'
                        
                    ),
                    'login-js' => array(
                        getcwd() . '/public/libs/jquery/dist/jquery.min.js',
                        getcwd() . '/public/libs/jquery-ui/jquery-ui.min.js',
                        getcwd() . '/public/libs/slimScroll/jquery.slimscroll.min.js',
                        getcwd() . '/public/libs/bootstrap/dist/js/bootstrap.min.js',
                        getcwd() . '/public/libs/metisMenu/dist/metisMenu.min.js',
                        getcwd() . '/public/libs/iCheck/icheck.min.js',
                        getcwd() . '/public/libs/sparkline/index.js',
                        getcwd() . '/public/js/homer.js'
                    )
                )
            )
        ),
    )
);
