<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Versionamento
 *
 * @ORM\Table(name="versionamento", uniqueConstraints={@ORM\UniqueConstraint(name="versao", columns={"versao"})})
 * @ORM\Entity
 */
class Versionamento
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
     * @ORM\Column(name="versao", type="string", length=4, nullable=false)
     */
    private $versao;

    /**
     * @var string
     *
     * @ORM\Column(name="plataforma", type="string", length=7, nullable=false)
     */
    private $plataforma;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validade", type="date", nullable=true)
     */
    private $validade;

    /**
     * @var boolean
     *
     * @ORM\Column(name="atual", type="boolean", nullable=false)
     */
    private $atual;

    /**
     * @var boolean
     *
     * @ORM\Column(name="critica", type="boolean", nullable=false)
     */
    private $critica;



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
     * Set versao
     *
     * @param string $versao
     * @return Versionamento
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;

        return $this;
    }

    /**
     * Get versao
     *
     * @return string 
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set plataforma
     *
     * @param string $plataforma
     * @return Versionamento
     */
    public function setPlataforma($plataforma)
    {
        $this->plataforma = $plataforma;

        return $this;
    }

    /**
     * Get plataforma
     *
     * @return string 
     */
    public function getPlataforma()
    {
        return $this->plataforma;
    }

    /**
     * Set validade
     *
     * @param \DateTime $validade
     * @return Versionamento
     */
    public function setValidade($validade)
    {
        $this->validade = $validade;

        return $this;
    }

    /**
     * Get validade
     *
     * @return \DateTime 
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * Set atual
     *
     * @param boolean $atual
     * @return Versionamento
     */
    public function setAtual($atual)
    {
        $this->atual = $atual;

        return $this;
    }

    /**
     * Get atual
     *
     * @return boolean 
     */
    public function getAtual()
    {
        return $this->atual;
    }

    /**
     * Set critica
     *
     * @param boolean $critica
     * @return Versionamento
     */
    public function setCritica($critica)
    {
        $this->critica = $critica;

        return $this;
    }

    /**
     * Get critica
     *
     * @return boolean 
     */
    public function getCritica()
    {
        return $this->critica;
    }
}
