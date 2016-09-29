<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Whitelist
 *
 * @ORM\Table(name="whitelist")
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Whitelist
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
     * @var string
     *
     * @ORM\Column(name="whitelist_name", type="string", length=255, nullable=false)
     */
    private $whitelistName;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set whitelistName
     *
     * @param string $whitelistName
     *
     * @return Whitelist
     */
    public function setWhitelistName($whitelistName)
    {
        $this->whitelistName = $whitelistName;

        return $this;
    }

    /**
     * Get whitelistName
     *
     * @return string
     */
    public function getWhitelistName()
    {
        return $this->whitelistName;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Whitelist
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
     * @return Whitelist
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
     * @return Whitelist
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
}
