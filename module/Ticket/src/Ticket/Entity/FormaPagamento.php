<?php

namespace Ticket\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormaPagamento
 *
 * @ORM\Table(name="forma_pagamento", uniqueConstraints={@ORM\UniqueConstraint(name="descricao_UNIQUE", columns={"descricao"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class FormaPagamento extends \Base\Entity\AbstractEntity {

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
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    private $descricao;

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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return FormaPagamento
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return FormaPagamento
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
