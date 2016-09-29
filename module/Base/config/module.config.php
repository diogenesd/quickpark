<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Base;

return array(
    'router' => array(
        'routes' => array(
            'permissiondenied' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/permissiondenied',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Base\Controller',
                        'controller'    => 'Error',
                        'action'        => 'permissiondenied',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Base\Controller\Error' => 'Base\Controller\ErrorController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/base.phtml',
            'base/index/index' =>    __DIR__ . '/../view/base/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'layout/flashMessage'    => __DIR__ . '/../view/layout/flashMessage.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        
        
    )
);
