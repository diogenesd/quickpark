<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Whitelist
 *
 * @ORM\Table(name="whitelist")
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Whitelist extends \Base\Entity\AbstractEntity {

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
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set whitelistName
     *
     * @param string $whitelistName
     *
     * @return Whitelist
     */
    public function setWhitelistName($whitelistName) {
        $this->whitelistName = $whitelistName;

        return $this;
    }

    /**
     * Get whitelistName
     *
     * @return string
     */
    public function getWhitelistName() {
        return $this->whitelistName;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Whitelist
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
