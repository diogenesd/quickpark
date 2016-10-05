<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resource
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Resource extends \Base\Entity\AbstractEntity {

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
     * @ORM\Column(name="resource_name", type="string", length=255, nullable=false)
     */
    private $resourceName;

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
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_on", type="datetime", nullable=false)
     */
    private $modifiedOn;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set resourceName
     *
     * @param string $resourceName
     *
     * @return Resource
     */
    public function setResourceName($resourceName) {
        $this->resourceName = $resourceName;

        return $this;
    }

    /**
     * Get resourceName
     *
     * @return string
     */
    public function getResourceName() {
        return $this->resourceName;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Resource
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
