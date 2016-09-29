<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RolePermission
 *
 * @ORM\Table(name="role_permission", indexes={@ORM\Index(name="fk_role_permission_permission_idx", columns={"role_id"}), @ORM\Index(name="fk_role_permission_role_idx", columns={"permission_id"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class RolePermission
{
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_on", type="datetime", nullable=false)
     */
    private $modifiedOn = 'CURRENT_TIMESTAMP';

    /**
     * @var \Login\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \Login\Entity\Permission
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\Permission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     * })
     */
    private $permission;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return RolePermission
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return RolePermission
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set modifiedOn
     *
     * @param \DateTime $modifiedOn
     *
     * @return RolePermission
     */
    public function setModifiedOn($modifiedOn)
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }

    /**
     * Get modifiedOn
     *
     * @return \DateTime
     */
    public function getModifiedOn()
    {
        return $this->modifiedOn;
    }

    /**
     * Set role
     *
     * @param \Login\Entity\Role $role
     *
     * @return RolePermission
     */
    public function setRole(\Login\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Login\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set permission
     *
     * @param \Login\Entity\Permission $permission
     *
     * @return RolePermission
     */
    public function setPermission(\Login\Entity\Permission $permission = null)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return \Login\Entity\Permission
     */
    public function getPermission()
    {
        return $this->permission;
    }
}