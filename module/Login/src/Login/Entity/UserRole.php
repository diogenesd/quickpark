<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 *
 * @ORM\Table(name="user_role", indexes={@ORM\Index(name="fk_user_role_user_idx", columns={"user_id"}), @ORM\Index(name="fk_user_role_role_idx", columns={"role_id"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class UserRole extends \Base\Entity\AbstractEntity {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $active = '1';
    private $role;

    /**
     * @var \Login\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return UserRole
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

    /**
     * Set role
     *
     * @param \Login\Entity\Role $role
     *
     * @return UserRole
     */
    public function setRole(\Login\Entity\Role $role = null) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Login\Entity\Role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set user
     *
     * @param \Login\Entity\User $user
     *
     * @return UserRole
     */
    public function setUser(\Login\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Login\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

}
