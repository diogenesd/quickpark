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
            'cadastro' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/cadastro',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller' => 'User',
                        'action' => 'insert'
                    )
                )
            ),
            'recuperarsenha' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/recuperarsenha',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller' => 'User',
                        'action' => 'recuperarsenha'
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
            'Login\Controller\User' => 'Login\Controller\UserController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/login' => __DIR__ . '/../view/layout/login.phtml',
            'login/index/index' => __DIR__ . '/../view/login/index/index.phtml',
            'login/user/insert' => __DIR__ . '/../view/login/user/insert.phtml',
            'login/user/recuperarsenha' => __DIR__ . '/../view/login/user/recuperarsenha.phtml',
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
