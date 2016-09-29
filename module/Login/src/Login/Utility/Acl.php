<?php
namespace Login\Utility;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Acl extends ZendAcl implements ServiceLocatorAwareInterface
{

    const DEFAULT_ROLE = 'guest';

    protected $_roleTableObject;

    protected $serviceLocator;

    protected $roles;

    protected $permissions;

    protected $resources;

    protected $rolePermission;

    protected $commonPermission;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function initAcl()
    {
        $this->roles = $this->_getAllRoles();
        $this->resources = $this->_getAllResources();
        $this->rolePermission = $this->_getRolePermissions();
        // we are not putting these resource & permission in table bcz it is
        // common to all user
        $this->commonPermission = array(
            'Login\Controller\Index' => array(
                'logout',
                'index'                
            )
        );
        $this->_addRoles()
            ->_addResources()
            ->_addRoleResources();
    }

    public function isAccessAllowed($roles, $resource, $permission)
    {
        if (! $this->hasResource($resource)) {
            return false;
        }
        foreach($roles as $role){
            if($role->getRoleName() == 'Master' || $this->isAllowed($role->getRoleName(), $resource, $permission))
                return true;
        }
        return false;
    }

    protected function _addRoles()
    {
        $this->addRole(new Role(self::DEFAULT_ROLE));
        
        if (! empty($this->roles)) {
            foreach ($this->roles as $role) {
                $roleName = $role['role_name'];
                if (! $this->hasRole($roleName)) {
                    $this->addRole(new Role($roleName), self::DEFAULT_ROLE);
                }
            }
        }
        return $this;
    }

    protected function _addResources()
    {
        if (! empty($this->resources)) {
            foreach ($this->resources as $resource) {
                if (! $this->hasResource($resource['resource_name'])) {
                    $this->addResource(new Resource($resource['resource_name']));
                }
            }
        }
        
        // add common resources
        if (! empty($this->commonPermission)) {
            foreach ($this->commonPermission as $resource => $permissions) {
                if (! $this->hasResource($resource)) {
                    $this->addResource(new Resource($resource));
                }
            }
        }
        
        return $this;
    }

    protected function _addRoleResources()
    {
        // allow common resource/permission to guest user
        if (! empty($this->commonPermission)) {
            foreach ($this->commonPermission as $resource => $permissions) {
                foreach ($permissions as $permission) {
                    $this->allow(self::DEFAULT_ROLE, $resource, $permission);
                }
            }
        }
        
        if (! empty($this->rolePermission)) {
            foreach ($this->rolePermission as $rolePermissions) {
                $this->allow($rolePermissions['roleName'], $rolePermissions['resourceName'], $rolePermissions['permissionName']);
            }
        }
        
        return $this;
    }

    protected function _getAllRoles()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $lista = $em->getRepository('Login\Entity\Role')->findBy(array('active'=>1));
        $retorno = array();
        foreach($lista as $role){
            array_push($retorno, $role->toArray());
        }
        return $retorno;
    }

    protected function _getAllResources()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $lista = $em->getRepository('Login\Entity\Resource')->findBy(array('active'=>1));
        $retorno = array();
        foreach($lista as $resource){
            array_push($retorno, $resource->toArray());
        }
        return $retorno;
    }

    protected function _getRolePermissions()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        return $em->getRepository('Login\Entity\RolePermission')->getRolePermissions();
    }
    
    private function debugAcl($role, $resource, $permission)
    {
        echo 'Role:-' . $role . '==>' . $resource . '\\' . $permission . '<br/>';
    }
}
