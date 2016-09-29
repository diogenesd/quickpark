<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'user' => 'localhost',
                    'password' => 'localhost',
                    'dbname' => 'quickpark',
                    'driverOptions' => array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                    )
                )
            )
        ),
        'configuration' => array(
            'orm_default' => array(
                'numeric_functions'=> array(
                    'Rand' => 'Doctrine\ORM\Extension\Rand'
                )
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Login\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function(Login\Entity\User $user, $passwordGiven) {
                    if($user->getPassword() == $passwordGiven)
                        return (bool)$user->getActive();
                    return false;
                },
            ),
        ),
    ),
    'myConfiguration' => array(
        'firephp' => 1
    )
);
