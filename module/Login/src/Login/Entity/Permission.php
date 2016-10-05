<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permission
 *
 * @ORM\Table(name="permission", indexes={@ORM\Index(name="fk_permission_resource_idx", columns={"resource_id"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Permission extends \Base\Entity\AbstractEntity {

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
     * @ORM\Column(name="permission_name", type="string", length=255, nullable=false)
     */
    private $permissionName;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $active = '1';

    /**
     * @var \Login\Entity\Resource
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\Resource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     * })
     */
    private $resource;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set permissionName
     *
     * @param string $permissionName
     *
     * @return Permission
     */
    public function setPermissionName($permissionName) {
        $this->permissionName = $permissionName;

        return $this;
    }

    /**
     * Get permissionName
     *
     * @return string
     */
    public function getPermissionName() {
        return $this->permissionName;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Permission
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
     * Set resource
     *
     * @param \Login\Entity\Resource $resource
     *
     * @return Permission
     */
    public function setResource(\Login\Entity\Resource $resource = null) {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \Login\Entity\Resource
     */
    public function getResource() {
        return $this->resource;
    }

}
