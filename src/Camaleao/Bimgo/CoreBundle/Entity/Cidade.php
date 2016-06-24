<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cidade
 *
 * @ORM\Table(name="cidade", indexes={@ORM\Index(name="estado", columns={"estado"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\CidadeRepository")
 */
class Cidade
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=200, nullable=false)
     */
    private $nome;

    /**
     * @var boolean
     *
     * @ORM\Column(name="participante", type="boolean", nullable=false)
     */
    private $participante = false;

    /**
     * @var \Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado", referencedColumnName="id")
     * })
     */
    private $estado;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Cidade
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set participante
     *
     * @param boolean $participante
     * @return Cidade
     */
    public function setParticipante($participante)
    {
        $this->participante = $participante;

        return $this;
    }

    /**
     * Get participante
     *
     * @return boolean
     */
    public function getParticipante()
    {
        return $this->participante;
    }

    /**
     * Set estado
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Estado $estado
     * @return Cidade
     */
    public function setEstado(\Camaleao\Bimgo\CoreBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }
}