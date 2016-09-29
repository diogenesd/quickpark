<?php

namespace Login\Entity;

/**
 * RolePermissionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RolePermissionRepository extends \Doctrine\ORM\EntityRepository {

    public function getRolePermissions() {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('r.roleName', 'p.permissionName', 'res.resourceName'))
            ->from('Login\Entity\Role', 'r')
            
            ->leftJoin('Login\Entity\RolePermission', 'rp', \Doctrine\ORM\Query\Expr\Join::WITH, 'r = rp.role')
            ->leftJoin('Login\Entity\Permission', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p = rp.permission')
            ->leftJoin('Login\Entity\Resource', 'res', \Doctrine\ORM\Query\Expr\Join::WITH, 'res = p.resource')
                
            ->andWhere('r.active = 1 AND rp.active = 1 AND p.active = 1 AND res.active = 1')
            ->andWhere('p.permissionName is not null and res.resourceName is not null')
             ->orderBy('r.id');
            
        $result = $qb->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        return $result; 
       
    }

}
