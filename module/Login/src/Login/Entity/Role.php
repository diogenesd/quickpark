<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Role extends \Base\Entity\AbstractEntity {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=255, nullable=false)
     */
    private $roleName;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $active = '1';

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set roleName
     *
     * @param string $roleName
     *
     * @return Role
     */
    public function setRoleName($roleName) {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName
     *
     * @return string
     */
    public function getRoleName() {
        return $this->roleName;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Role
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return int
     */
    public function getActive() {
        return $this->active;
    }

}
