<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Promocao
 *
 * @ORM\Table(name="promocao", indexes={@ORM\Index(name="instituicao", columns={"instituicao"}), @ORM\Index(name="fk_usuarioid_promocao_criadopor", columns={"criadoPor"}), @ORM\Index(name="fk_usuarioid_promocao_modificadopor", columns={"modificadoPor"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\PromocaoRepository")
 * @ORM\EntityListeners({"Camaleao\Bimgo\CoreBundle\EventListener\PromocaoListener"})
 */
class Promocao
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
     * @var \DateTime
     *
     * @ORM\Column(name="dataInicio", type="date", nullable=false)
     */
    private $datainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataFim", type="date", nullable=false)
     */
    private $datafim;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publicada", type="boolean", nullable=false)
     */
    private $publicada = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriacao", type="datetime", nullable=false)
     *
     * @Exclude
     */
    private $datacriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataModificacao", type="datetime", nullable=false)
     *
     * @Exclude
     */
    private $datamodificacao;

    /**
     * @var \Instituicao
     *
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     * })
     */
    private $instituicao;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="criadoPor", referencedColumnName="id")
     * })
     */
    private $criadopor;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modificadoPor", referencedColumnName="id")
     * })
     */
    private $modificadopor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Oferta", mappedBy="promocao")
     */
    private $oferta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datacriacao = new \DateTime();
        $this->oferta = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Promocao
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
     * @return Promocao
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
     * Set datainicio
     *
     * @param \DateTime $datainicio
     * @return Promocao
     */
    public function setDatainicio($datainicio)
    {
        $this->datainicio = $datainicio;

        return $this;
    }

    /**
     * Get datainicio
     *
     * @return \DateTime 
     */
    public function getDatainicio()
    {
        return $this->datainicio;
    }

    /**
     * Set datafim
     *
     * @param \DateTime $datafim
     * @return Promocao
     */
    public function setDatafim($datafim)
    {
        $this->datafim = $datafim;

        return $this;
    }

    /**
     * Get datafim
     *
     * @return \DateTime 
     */
    public function getDatafim()
    {
        return $this->datafim;
    }

    /**
     * Set publicada
     *
     * @param boolean $publicada
     * @return Promocao
     */
    public function setPublicada($publicada)
    {
        $this->publicada = $publicada;

        return $this;
    }

    /**
     * Get publicada
     *
     * @return boolean 
     */
    public function getPublicada()
    {
        return $this->publicada;
    }

    /**
     * Set datacriacao
     *
     * @param \DateTime $datacriacao
     * @return Promocao
     */
    public function setDatacriacao($datacriacao)
    {
        $this->datacriacao = $datacriacao;

        return $this;
    }

    /**
     * Get datacriacao
     *
     * @return \DateTime 
     */
    public function getDatacriacao()
    {
        return $this->datacriacao;
    }

    /**
     * Set datamodificacao
     *
     * @param \DateTime $datamodificacao
     * @return Promocao
     */
    public function setDatamodificacao($datamodificacao)
    {
        $this->datamodificacao = $datamodificacao;

        return $this;
    }

    /**
     * Get datamodificacao
     *
     * @return \DateTime 
     */
    public function getDatamodificacao()
    {
        return $this->datamodificacao;
    }

    /**
     * Set instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Promocao
     */
    public function setInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao = null)
    {
        $this->instituicao = $instituicao;

        return $this;
    }

    /**
     * Get instituicao
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Instituicao 
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Set criadopor
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $criadopor
     * @return Promocao
     */
    public function setCriadopor(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $criadopor = null)
    {
        $this->criadopor = $criadopor;

        return $this;
    }

    /**
     * Get criadopor
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Usuario 
     */
    public function getCriadopor()
    {
        return $this->criadopor;
    }

    /**
     * Set modificadopor
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $modificadopor
     * @return Promocao
     */
    public function setModificadopor(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $modificadopor = null)
    {
        $this->modificadopor = $modificadopor;

        return $this;
    }

    /**
     * Get modificadopor
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Usuario 
     */
    public function getModificadopor()
    {
        return $this->modificadopor;
    }

    /**
     * Add oferta
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Oferta $oferta
     * @return Promocao
     */
    public function addOfertum(\Camaleao\Bimgo\CoreBundle\Entity\Oferta $oferta)
    {
        $this->oferta[] = $oferta;

        return $this;
    }

    /**
     * Remove oferta
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Oferta $oferta
     */
    public function removeOfertum(\Camaleao\Bimgo\CoreBundle\Entity\Oferta $oferta)
    {
        $this->oferta->removeElement($oferta);
    }

    /**
     * Get oferta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOferta()
    {
        return $this->oferta;
    }
}
