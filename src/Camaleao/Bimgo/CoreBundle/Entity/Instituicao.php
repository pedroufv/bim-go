<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Instituicao
 *
 * @ORM\Table(name="instituicao", indexes={@ORM\Index(name="endereco", columns={"endereco"}), @ORM\Index(name="criadoPor", columns={"criadoPor", "modificadoPor"}), @ORM\Index(name="modificadoPor", columns={"modificadoPor"}), @ORM\Index(name="grupo", columns={"vinculada"}), @ORM\Index(name="plano", columns={"plano"}), @ORM\Index(name="IDX_7CFF8F698F3195FB", columns={"criadoPor"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\InstituicaoRepository")
 * @ORM\EntityListeners({"Camaleao\Bimgo\CoreBundle\EventListener\InstituicaoListener"})
 */
class Instituicao
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
     * @ORM\Column(name="razaoSocial", type="string", length=200, nullable=true)
     */
    private $razaosocial;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeFantasia", type="string", length=200, nullable=false)
     */
    private $nomefantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=false)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="cnpj", type="integer", nullable=true)
     */
    private $cnpj;

    /**
     * @var integer
     *
     * @ORM\Column(name="inscricaoEstadual", type="integer", nullable=true)
     */
    private $inscricaoestadual;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fidelidade", type="boolean", nullable=false)
     */
    private $fidelidade = false;

    /**
     * @var string
     *
     * @ORM\Column(name="conversao", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $conversao;

    /**
     * @var boolean
     *
     * @ORM\Column(name="grupo", type="boolean", nullable=false)
     */
    private $grupo = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo = true;

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
     * @var \Endereco
     *
     * @ORM\ManyToOne(targetEntity="Endereco", cascade="all")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endereco", referencedColumnName="id")
     * })
     */
    private $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="canonico", type="string", length=250, nullable=false)
     */
    private $canonico;

    /**
     * @var \Instituicao
     *
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vinculada", referencedColumnName="id")
     * })
     */
    private $vinculada;

    /**
     * @var boolean
     *
     * @ORM\Column(name="associada", type="boolean", nullable=false)
     */
    private $associada = false;

    /**
     * @var \Plano
     *
     * @ORM\ManyToOne(targetEntity="Plano")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plano", referencedColumnName="id")
     * })
     */
    private $plano;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Contato", inversedBy="instituicao", cascade={"all"})
     * @ORM\JoinTable(name="instituicao_contato",
     *   joinColumns={
     *     @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="contato", referencedColumnName="id")
     *   }
     * )
     */
    private $contato;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Segmento", inversedBy="instituicao", cascade={"all"})
     * @ORM\JoinTable(name="instituicao_segmento",
     *   joinColumns={
     *     @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="segmento", referencedColumnName="id")
     *   }
     * )
     */
    private $segmento;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="gerenciadas")
     * @ORM\JoinTable(name="membro",
     *   joinColumns={
     *     @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     *   }
     * )
     *
     * @Exclude
     */
    private $membros;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="seguidas")
     * @ORM\JoinTable(name="seguidor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     *   }
     * )
     * @Exclude
     */
    private $seguidores;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datacriacao = new \DateTime();
        $this->contato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->segmento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->membros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seguidores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set razaosocial
     *
     * @param string $razaosocial
     * @return Instituicao
     */
    public function setRazaosocial($razaosocial)
    {
        $this->razaosocial = $razaosocial;

        return $this;
    }

    /**
     * Get razaosocial
     *
     * @return string
     */
    public function getRazaosocial()
    {
        return $this->razaosocial;
    }

    /**
     * Set nomefantasia
     *
     * @param string $nomefantasia
     * @return Instituicao
     */
    public function setNomefantasia($nomefantasia)
    {
        $this->nomefantasia = $nomefantasia;

        return $this;
    }

    /**
     * Get nomefantasia
     *
     * @return string
     */
    public function getNomefantasia()
    {
        return $this->nomefantasia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Instituicao
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
     * Set cnpj
     *
     * @param integer $cnpj
     * @return Instituicao
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get cnpj
     *
     * @return integer
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set inscricaoestadual
     *
     * @param integer $inscricaoestadual
     * @return Instituicao
     */
    public function setInscricaoestadual($inscricaoestadual)
    {
        $this->inscricaoestadual = $inscricaoestadual;

        return $this;
    }

    /**
     * Get inscricaoestadual
     *
     * @return integer
     */
    public function getInscricaoestadual()
    {
        return $this->inscricaoestadual;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Instituicao
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set fidelidade
     *
     * @param boolean $fidelidade
     * @return Instituicao
     */
    public function setFidelidade($fidelidade)
    {
        $this->fidelidade = $fidelidade;

        return $this;
    }

    /**
     * Get fidelidade
     *
     * @return boolean
     */
    public function getFidelidade()
    {
        return $this->fidelidade;
    }

    /**
     * Set conversao
     *
     * @param string $conversao
     * @return Instituicao
     */
    public function setConversao($conversao)
    {
        $this->conversao = $conversao;

        return $this;
    }

    /**
     * Get conversao
     *
     * @return string
     */
    public function getConversao()
    {
        return $this->conversao;
    }

    /**
     * Set grupo
     *
     * @param boolean $grupo
     * @return Instituicao
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return boolean
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Instituicao
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo == null ? true : $ativo;

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
     * Set datacriacao
     *
     * @param \DateTime $datacriacao
     * @return Instituicao
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
     * @return Instituicao
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
     * Set criadopor
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $criadopor
     * @return Instituicao
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
     * @return Instituicao
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
     * Set endereco
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Endereco $endereco
     * @return Instituicao
     */
    public function setEndereco(\Camaleao\Bimgo\CoreBundle\Entity\Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
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
     * Set vinculada
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $vinculada
     * @return Instituicao
     */
    public function setVinculada(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $vinculada = null)
    {
        $this->vinculada = $vinculada;

        return $this;
    }

    /**
     * Get vinculada
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Instituicao
     */
    public function getVinculada()
    {
        return $this->vinculada;
    }

    /**
     * @return boolean
     */
    public function getAssociada()
    {
        return $this->associada;
    }

    /**
     * @param boolean $associada
     */
    public function setAssociada($associada)
    {
        $this->associada = $associada;
    }

    /**
     * Set plano
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Plano $plano
     * @return Instituicao
     */
    public function setPlano(\Camaleao\Bimgo\CoreBundle\Entity\Plano $plano = null)
    {
        $this->plano = $plano;

        return $this;
    }

    /**
     * Get plano
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Plano
     */
    public function getPlano()
    {
        return $this->plano;
    }

    /**
     * Add contato
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Contato $contato
     * @return Instituicao
     */
    public function addContato(\Camaleao\Bimgo\CoreBundle\Entity\Contato $contato)
    {
        $this->contato[] = $contato;

        return $this;
    }

    /**
     * Remove contato
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Contato $contato
     */
    public function removeContato(\Camaleao\Bimgo\CoreBundle\Entity\Contato $contato)
    {
        $this->contato->removeElement($contato);
    }

    /**
     * Get contato
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Add segmento
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Segmento $segmento
     * @return Instituicao
     */
    public function addSegmento(\Camaleao\Bimgo\CoreBundle\Entity\Segmento $segmento)
    {
        $this->segmento[] = $segmento;

        return $this;
    }

    /**
     * Remove segmento
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Segmento $segmento
     */
    public function removeSegmento(\Camaleao\Bimgo\CoreBundle\Entity\Segmento $segmento)
    {
        $this->segmento->removeElement($segmento);
    }

    /**
     * Get segmento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSegmento()
    {
        return $this->segmento;
    }

    /**
     * Get Membros
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembros()
    {
        return $this->membros;
    }

    /**
     * Get Seguidores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguidores()
    {
        return $this->seguidores;
    }
}
