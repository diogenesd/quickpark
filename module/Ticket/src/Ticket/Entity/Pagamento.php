<?php

namespace Ticket\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pagamento
 *
 * @ORM\Table(name="pagamento", indexes={@ORM\Index(name="fk_pagamento_forma_pagamento_idx", columns={"forma_pagamento_id"}), @ORM\Index(name="fk_pagamento_funcionario_idx", columns={"funcionario_id"}), @ORM\Index(name="fk_pagamento_cliente_idx", columns={"cliente_id"}), @ORM\Index(name="fk_pagamento_bilhete_idx", columns={"bilhete_id"})})
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Pagamento
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
     * @ORM\Column(name="valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valor;

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
     * @var \Ticket\Entity\Bilhete
     *
     * @ORM\ManyToOne(targetEntity="Ticket\Entity\Bilhete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bilhete_id", referencedColumnName="id")
     * })
     */
    private $bilhete;

    /**
     * @var \Ticket\Entity\Cliente
     *
     * @ORM\ManyToOne(targetEntity="Ticket\Entity\Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;

    /**
     * @var \Ticket\Entity\FormaPagamento
     *
     * @ORM\ManyToOne(targetEntity="Ticket\Entity\FormaPagamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forma_pagamento_id", referencedColumnName="id")
     * })
     */
    private $formaPagamento;

    /**
     * @var \Ticket\Entity\Funcionario
     *
     * @ORM\ManyToOne(targetEntity="Ticket\Entity\Funcionario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="funcionario_id", referencedColumnName="id")
     * })
     */
    private $funcionario;



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
     * Set valor
     *
     * @param string $valor
     *
     * @return Pagamento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Pagamento
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
     * @return Pagamento
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
     * @return Pagamento
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
     * Set bilhete
     *
     * @param \Ticket\Entity\Bilhete $bilhete
     *
     * @return Pagamento
     */
    public function setBilhete(\Ticket\Entity\Bilhete $bilhete = null)
    {
        $this->bilhete = $bilhete;

        return $this;
    }

    /**
     * Get bilhete
     *
     * @return \Ticket\Entity\Bilhete
     */
    public function getBilhete()
    {
        return $this->bilhete;
    }

    /**
     * Set cliente
     *
     * @param \Ticket\Entity\Cliente $cliente
     *
     * @return Pagamento
     */
    public function setCliente(\Ticket\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Ticket\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set formaPagamento
     *
     * @param \Ticket\Entity\FormaPagamento $formaPagamento
     *
     * @return Pagamento
     */
    public function setFormaPagamento(\Ticket\Entity\FormaPagamento $formaPagamento = null)
    {
        $this->formaPagamento = $formaPagamento;

        return $this;
    }

    /**
     * Get formaPagamento
     *
     * @return \Ticket\Entity\FormaPagamento
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * Set funcionario
     *
     * @param \Ticket\Entity\Funcionario $funcionario
     *
     * @return Pagamento
     */
    public function setFuncionario(\Ticket\Entity\Funcionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \Ticket\Entity\Funcionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
