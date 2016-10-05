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
                'type' => 'Literal',
                'options' => array(
                    'route' => '/permissiondenied',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Base\Controller',
                        'controller' => 'Error',
                        'action' => 'permissiondenied',
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
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/base.phtml',
            'base/index/index' => __DIR__ . '/../view/base/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'layout/flashMessage' => __DIR__ . '/../view/layout/flashMessage.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'TpMinify' => array(
        'serveOptions' => array(
            'minApp' => array(
                'groups' => array(
                    'datatables-js' => array(
                        getcwd() . '/public/libs/datatables-responsive/jquery.dataTables.min.js',
                        getcwd() . '/public/libs/datatables-responsive/dataTables.responsive.js',
                        getcwd() . '/public/libs/datatables-responsive/dataTables.bootstrap.js',
                        getcwd() . '/public/libs/pdfmake/build/pdfmake.min.js',
                        getcwd() . '/public/libs/pdfmake/build/vfs_fonts.js',
                        getcwd() . '/public/libs/datatables.net-buttons/js/buttons.html5.min.js',
                        getcwd() . '/public/libs/datatables.net-buttons/js/buttons.print.min.js',
                        getcwd() . '/public/libs/datatables.net-buttons/js/dataTables.buttons.min.js',
                        getcwd() . '/public/libs/datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
                        getcwd() . '/public/js/dataTablesCustom.js',
                    )
                )
            )
        ),
    )
);
