<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produto
 *
 * @ORM\Table(name="produto", indexes={@ORM\Index(name="empresa", columns={"empresa"})})
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
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     * })
     */
    private $empresa;

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
