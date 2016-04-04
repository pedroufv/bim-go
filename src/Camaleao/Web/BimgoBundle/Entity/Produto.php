<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produto
 *
 * @ORM\Table(name="produto", indexes={@ORM\Index(name="empresa", columns={"empresa"}), @ORM\Index(name="fk_usuarioid_produto_criadopor", columns={"criadoPor"}), @ORM\Index(name="fk_usuarioid_produto_modificadopor", columns={"modificadoPor"})})
 * @ORM\Entity
 */
class Produto
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
     * @ORM\Column(name="preco", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $preco;

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
     * @var string
     *
     * @ORM\Column(name="ean", type="text", length=13, nullable=true)
     */
    private $ean;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     * })
     */
    private $empresa;

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
     * @ORM\ManyToMany(targetEntity="Promocao", inversedBy="produto")
     * @ORM\JoinTable(name="produto_promocao",
     *   joinColumns={
     *     @ORM\JoinColumn(name="produto", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="promocao", referencedColumnName="id")
     *   }
     * )
     */
    private $promocao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->promocao = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Produto
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
     * @return Produto
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
     * Set preco
     *
     * @param string $preco
     * @return Produto
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }

    /**
     * Get preco
     *
     * @return string 
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * Set datacriado
     *
     * @param \DateTime $datacriado
     * @return Produto
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
     * @return Produto
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
     * Set empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     * @return Produto
     */
    public function setEmpresa(\Camaleao\Web\BimgoBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set criadopor
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $criadopor
     * @return Produto
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
     * @return Produto
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
     * Add promocao
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Promocao $promocao
     * @return Produto
     */
    public function addPromocao(\Camaleao\Web\BimgoBundle\Entity\Promocao $promocao)
    {
        $this->promocao[] = $promocao;

        return $this;
    }

    /**
     * Remove promocao
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Promocao $promocao
     */
    public function removePromocao(\Camaleao\Web\BimgoBundle\Entity\Promocao $promocao)
    {
        $this->promocao->removeElement($promocao);
    }

    /**
     * Get promocao
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPromocao()
    {
        return $this->promocao;
    }
}
