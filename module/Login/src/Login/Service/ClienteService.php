<?php

namespace Login\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

/**
 * Description of ClienteService
 *
 * @author rodrigoheinzle
 */
class ClienteService extends AbstractService {

    public function __construct(EntityManager $em) {
        $this->entity = 'Admin\Entity\Cliente';
        $this->entityUser = 'Login\Entity\User';
        parent::__construct($em);
    }

    public function save(Array $data = array()) {
        if (isset($data['id'])) {

            $entityUser = $this->em->getReference($this->entityUser, $data['id']);

            $entity = $this->em->getReference($this->entity, $data['id']);
            
            $hydrator = new ClassMethods();

            $hydrator->hydrate($data, $entity);
        } else {
            $entityUser = new $this->entityUser($data);
            $entity = new $this->entity($data);
        }
        $this->em->persist($entityUser);
        $this->em->flush();

        $entity->setUser($entityUser);
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

}
