<?php

namespace Ticket\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bilhete
 *
 * @ORM\Table(name="bilhete")
 * @ORM\Entity(repositoryClass="Base\Entity\GlobalRepository")
 */
class Bilhete {

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
     * @ORM\Column(name="codigo", type="string", length=255, nullable=false)
     */
    private $codigo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entrada", type="datetime", nullable=false)
     */
    private $entrada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saida", type="datetime", nullable=true)
     */
    private $saida;

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
    public function getId() {
        return $this->id;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Bilhete
     */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Set entrada
     *
     * @param \DateTime $entrada
     *
     * @return Bilhete
     */
    public function setEntrada($entrada) {
        $this->entrada = $entrada;

        return $this;
    }

    /**
     * Get entrada
     *
     * @return \DateTime
     */
    public function getEntrada() {
        return $this->entrada;
    }

    /**
     * Set saida
     *
     * @param \DateTime $saida
     *
     * @return Bilhete
     */
    public function setSaida($saida) {
        $this->saida = $saida;

        return $this;
    }

    /**
     * Get saida
     *
     * @return \DateTime
     */
    public function getSaida() {
        return $this->saida;
    }

    /**
     * Set active
     *
     * @param int $active
     *
     * @return Bilhete
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
     * @return Bilhete
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
     * @return Bilhete
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
