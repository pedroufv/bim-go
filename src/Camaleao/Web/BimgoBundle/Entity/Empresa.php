<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa", indexes={@ORM\Index(name="endereco", columns={"endereco"}), @ORM\Index(name="criadoPor", columns={"criadoPor", "modificadoPor"}), @ORM\Index(name="modificadoPor", columns={"modificadoPor"}), @ORM\Index(name="grupo", columns={"vinculada"}), @ORM\Index(name="IDX_B8D75A508F3195FB", columns={"criadoPor"})})
 * @ORM\Entity(repositoryClass="Camaleao\Web\BimgoBundle\Entity\EmpresaRepository")
 */
class Empresa
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
     * @ORM\Column(name="grupo", type="boolean", nullable=false)
     */
    private $grupo;

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
     * @var \Endereco
     *
     * @ORM\ManyToOne(targetEntity="Endereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endereco", referencedColumnName="id")
     * })
     */
    private $endereco;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vinculada", referencedColumnName="id")
     * })
     */
    private $vinculada;

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
     * @ORM\ManyToMany(targetEntity="Contato", inversedBy="empresa")
     * @ORM\JoinTable(name="empresa_contato",
     *   joinColumns={
     *     @ORM\JoinColumn(name="empresa", referencedColumnName="id")
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
     * @ORM\ManyToMany(targetEntity="Segmento", mappedBy="empresa")
     */
    private $segmento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->segmento = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * Set grupo
     *
     * @param boolean $grupo
     * @return Empresa
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
     * Set datacriado
     *
     * @param \DateTime $datacriado
     * @return Empresa
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
     * @return Empresa
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
     * Set endereco
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Endereco $endereco
     * @return Empresa
     */
    public function setEndereco(\Camaleao\Web\BimgoBundle\Entity\Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Endereco 
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set vinculada
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $vinculada
     * @return Empresa
     */
    public function setVinculada(\Camaleao\Web\BimgoBundle\Entity\Empresa $vinculada = null)
    {
        $this->vinculada = $vinculada;

        return $this;
    }

    /**
     * Get vinculada
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Empresa 
     */
    public function getVinculada()
    {
        return $this->vinculada;
    }

    /**
     * Set criadopor
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $criadopor
     * @return Empresa
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
     * @return Empresa
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
     * Add contato
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Contato $contato
     * @return Empresa
     */
    public function addContato(\Camaleao\Web\BimgoBundle\Entity\Contato $contato)
    {
        $this->contato[] = $contato;

        return $this;
    }

    /**
     * Remove contato
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Contato $contato
     */
    public function removeContato(\Camaleao\Web\BimgoBundle\Entity\Contato $contato)
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
     * @param \Camaleao\Web\BimgoBundle\Entity\Segmento $segmento
     * @return Empresa
     */
    public function addSegmento(\Camaleao\Web\BimgoBundle\Entity\Segmento $segmento)
    {
        $this->segmento[] = $segmento;

        return $this;
    }

    /**
     * Remove segmento
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Segmento $segmento
     */
    public function removeSegmento(\Camaleao\Web\BimgoBundle\Entity\Segmento $segmento)
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
}
