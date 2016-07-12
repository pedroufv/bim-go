<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Segmento
 *
 * @ORM\Table(name="segmento", indexes={@ORM\Index(name="icone", columns={"icone"})})
 * @ORM\Entity
 * @ORM\EntityListeners({"Camaleao\Bimgo\CoreBundle\EventListener\SegmentoListener"})
 */
class Segmento
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
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=false)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="canonico", type="string", length=250, unique=true, nullable=false)
     */
    private $canonico;

    /**
     * @var \Icone
     *
     * @ORM\ManyToOne(targetEntity="Icone")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="icone", referencedColumnName="id")
     * })
     */
    private $icone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo = true;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Instituicao", mappedBy="segmento")
     *
     * @Exclude
     */
    private $instituicao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instituicao = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * @return Segmento
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
     * Set descricao
     *
     * @param string $descricao
     * @return Segmento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @return string
     */
    public function getCanonico()
    {
        return $this->canonico;
    }

    /**
     * @param string $canonico
     * @return Instituicao
     */
    public function setCanonico($canonico)
    {
        $this->canonico = $canonico;

        return $this;
    }

    /**
     * Set icone
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Icone $icone
     * @return Segmento
     */
    public function setIcone(\Camaleao\Bimgo\CoreBundle\Entity\Icone $icone = null)
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * Get icone
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Icone
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Instituicao
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo === null ? true : $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Add instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Segmento
     */
    public function addInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao)
    {
        $this->instituicao[] = $instituicao;

        return $this;
    }

    /**
     * Remove instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     */
    public function removeInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao)
    {
        $this->instituicao->removeElement($instituicao);
    }

    /**
     * Get instituicao
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }
}

