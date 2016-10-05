<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuracao
 *
 * @ORM\Table(name="configuracao")
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Configuracao {

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
     * @ORM\Column(name="tolerancia_entrada", type="integer", nullable=false)
     */
    private $toleranciaEntrada;

    /**
     * @var int
     *
     * @ORM\Column(name="tolerancia_saida", type="integer", nullable=false)
     */
    private $toleranciaSaida;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_hora", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valorHora;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_diaria", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorDiaria;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_mensal", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorMensal;

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
    private $modifiedOn = 'CURRENT_TIMESTAMP';

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set toleranciaEntrada
     *
     * @param int $toleranciaEntrada
     *
     * @return Configuracao
     */
    public function setToleranciaEntrada($toleranciaEntrada) {
        $this->toleranciaEntrada = $toleranciaEntrada;

        return $this;
    }

    /**
     * Get toleranciaEntrada
     *
     * @return int
     */
    public function getToleranciaEntrada() {
        return $this->toleranciaEntrada;
    }

    /**
     * Set toleranciaSaida
     *
     * @param int $toleranciaSaida
     *
     * @return Configuracao
     */
    public function setToleranciaSaida($toleranciaSaida) {
        $this->toleranciaSaida = $toleranciaSaida;

        return $this;
    }

    /**
     * Get toleranciaSaida
     *
     * @return int
     */
    public function getToleranciaSaida() {
        return $this->toleranciaSaida;
    }

    /**
     * Set valorHora
     *
     * @param string $valorHora
     *
     * @return Configuracao
     */
    public function setValorHora($valorHora) {
        $this->valorHora = $valorHora;

        return $this;
    }

    /**
     * Get valorHora
     *
     * @return string
     */
    public function getValorHora() {
        return $this->valorHora;
    }

    /**
     * Set valorDiaria
     *
     * @param string $valorDiaria
     *
     * @return Configuracao
     */
    public function setValorDiaria($valorDiaria) {
        $this->valorDiaria = $valorDiaria;

        return $this;
    }

    /**
     * Get valorDiaria
     *
     * @return string
     */
    public function getValorDiaria() {
        return $this->valorDiaria;
    }

    /**
     * Set valorMensal
     *
     * @param string $valorMensal
     *
     * @return Configuracao
     */
    public function setValorMensal($valorMensal) {
        $this->valorMensal = $valorMensal;

        return $this;
    }

    /**
     * Get valorMensal
     *
     * @return string
     */
    public function getValorMensal() {
        return $this->valorMensal;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Configuracao
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Configuracao
     */
    public function setCreatedOn($createdOn) {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn() {
        return $this->createdOn;
    }

    /**
     * Set modifiedOn
     *
     * @param \DateTime $modifiedOn
     *
     * @return Configuracao
     */
    public function setModifiedOn($modifiedOn) {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }

    /**
     * Get modifiedOn
     *
     * @return \DateTime
     */
    public function getModifiedOn() {
        return $this->modifiedOn;
    }
}
