<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente", indexes={@ORM\Index(name="fk_cliente_user_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Cliente extends \Base\Entity\AbstractEntity {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * Set user
     *
     * @param \Login\Entity\User $user
     *
     * @return Cliente
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
