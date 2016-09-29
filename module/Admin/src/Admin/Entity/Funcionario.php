<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcionario
 *
 * @ORM\Table(name="funcionario", indexes={@ORM\Index(name="fk_funcionario_user_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Funcionario
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
     * @var \Admin\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\User")
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \Admin\Entity\User $user
     *
     * @return Funcionario
     */
    public function setUser(\Admin\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Admin\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
