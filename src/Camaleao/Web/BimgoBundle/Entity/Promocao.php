<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promocao
 *
 * @ORM\Table(name="promocao", indexes={@ORM\Index(name="instituicao", columns={"instituicao"}), @ORM\Index(name="fk_usuarioid_promocao_criadopor", columns={"criadoPor"}), @ORM\Index(name="fk_usuarioid_promocao_modificadopor", columns={"modificadoPor"})})
 * @ORM\Entity
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
    private $publicada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriado", type="datetime", nullable=false)
     */
    private $datacriado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataModificacao", type="datetime", nullable=false)
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
     * @ORM\ManyToMany(targetEntity="Produtopromocional", inversedBy="promocao")
     * @ORM\JoinTable(name="promocao_produtoPromocional",
     *   joinColumns={
     *     @ORM\JoinColumn(name="promocao", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="produtoPromocional", referencedColumnName="id")
     *   }
     * )
     */
    private $produtopromocional;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produtopromocional = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set datacriado
     *
     * @param \DateTime $datacriado
     * @return Promocao
     */
    public function setDatacriado($datacriado)
    {
        $this->datacriado = $datacriado;

        return $this;
    }

    /**
     * Get datacriado
     *
     * @return \DateTime 
     */
    public function getDatacriado()
    {
        return $this->datacriado;
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
     * @param \Camaleao\Web\BimgoBundle\Entity\Instituicao $instituicao
     * @return Promocao
     */
    public function setInstituicao(\Camaleao\Web\BimgoBundle\Entity\Instituicao $instituicao = null)
    {
        $this->instituicao = $instituicao;

        return $this;
    }

    /**
     * Get instituicao
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Instituicao 
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Set criadopor
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $criadopor
     * @return Promocao
     */
    public function setCriadopor(\Camaleao\Web\BimgoBundle\Entity\Usuario $criadopor = null)
    {
        $this->criadopor = $criadopor;

        return $this;
    }

    /**
     * Get criadopor
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getCriadopor()
    {
        return $this->criadopor;
    }

    /**
     * Set modificadopor
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $modificadopor
     * @return Promocao
     */
    public function setModificadopor(\Camaleao\Web\BimgoBundle\Entity\Usuario $modificadopor = null)
    {
        $this->modificadopor = $modificadopor;

        return $this;
    }

    /**
     * Get modificadopor
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getModificadopor()
    {
        return $this->modificadopor;
    }

    /**
     * Add produtopromocional
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Produtopromocional $produtopromocional
     * @return Promocao
     */
    public function addProdutopromocional(\Camaleao\Web\BimgoBundle\Entity\Produtopromocional $produtopromocional)
    {
        $this->produtopromocional[] = $produtopromocional;

        return $this;
    }

    /**
     * Remove produtopromocional
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Produtopromocional $produtopromocional
     */
    public function removeProdutopromocional(\Camaleao\Web\BimgoBundle\Entity\Produtopromocional $produtopromocional)
    {
        $this->produtopromocional->removeElement($produtopromocional);
    }

    /**
     * Get produtopromocional
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProdutopromocional()
    {
        return $this->produtopromocional;
    }
}
