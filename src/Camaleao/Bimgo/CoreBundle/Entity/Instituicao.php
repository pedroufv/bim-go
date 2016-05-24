<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instituicao
 *
 * @ORM\Table(name="instituicao", indexes={@ORM\Index(name="endereco", columns={"endereco"}), @ORM\Index(name="criadoPor", columns={"criadoPor", "modificadoPor"}), @ORM\Index(name="modificadoPor", columns={"modificadoPor"}), @ORM\Index(name="grupo", columns={"vinculada"}), @ORM\Index(name="plano", columns={"plano"}), @ORM\Index(name="IDX_7CFF8F698F3195FB", columns={"criadoPor"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\InstituicaoRepository")
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
     * @ORM\Column(name="grupo", type="boolean", nullable=false)
     */
    private $grupo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriacao", type="datetime", nullable=false)
     */
    private $datacriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataModificacao", type="datetime", nullable=false)
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
     * @ORM\ManyToOne(targetEntity="Endereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endereco", referencedColumnName="id")
     * })
     */
    private $endereco;

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
     * @ORM\ManyToMany(targetEntity="Contato", inversedBy="instituicao")
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
     * @ORM\ManyToMany(targetEntity="Segmento", mappedBy="instituicao")
     */
    private $segmento;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="instituicao")
     */
    private $usuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->segmento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->ativo = $ativo;

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
     * Add usuario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario
     * @return Instituicao
     */
    public function addUsuario(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}