<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa", indexes={@ORM\Index(name="entidade", columns={"grupoEmpresas"}), @ORM\Index(name="endereco", columns={"endereco"}), @ORM\Index(name="usuario", columns={"usuario"})})
 * @ORM\Entity
 * @JMS\Serializer\Annotation\ExclusionPolicy("all")
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
     * @ORM\Column(name="razaoSocial", type="string", length=200, nullable=false)
     */
    private $razaosocial;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeFantasia", type="string", length=200, nullable=false)
     *
     * @JMS\Serializer\Annotation\Expose
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
     * @ORM\Column(name="cnpj", type="integer", nullable=false)
     */
    private $cnpj;

    /**
     * @var integer
     *
     * @ORM\Column(name="inscricaoEstadual", type="integer", nullable=false)
     */
    private $inscricaoestadual;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=50, nullable=false)
     */
    private $telefone;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \Endereco
     *
     * @ORM\ManyToOne(targetEntity="Endereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endereco", referencedColumnName="id")
     * })
     *
     * @JMS\Serializer\Annotation\Expose
     */
    private $endereco;

    /**
     * @var \Grupoempresas
     *
     * @ORM\ManyToOne(targetEntity="Grupoempresas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupoEmpresas", referencedColumnName="id")
     * })
     */
    private $grupoempresas;

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
     * Set telefone
     *
     * @param string $telefone
     * @return Empresa
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set usuario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $usuario
     * @return Empresa
     */
    public function setUsuario(\Camaleao\Web\BimgoBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
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
     * Set grupoempresas
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Grupoempresas $grupoempresas
     * @return Empresa
     */
    public function setGrupoempresas(\Camaleao\Web\BimgoBundle\Entity\Grupoempresas $grupoempresas = null)
    {
        $this->grupoempresas = $grupoempresas;

        return $this;
    }

    /**
     * Get grupoempresas
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Grupoempresas 
     */
    public function getGrupoempresas()
    {
        return $this->grupoempresas;
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
