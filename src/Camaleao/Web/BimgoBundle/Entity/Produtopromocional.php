<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produtopromocional
 *
 * @ORM\Table(name="produtoPromocional", indexes={@ORM\Index(name="produto", columns={"produto"})})
 * @ORM\Entity
 */
class Produtopromocional
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
     * @ORM\Column(name="precoPromocional", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precopromocional;

    /**
     * @var \Produto
     *
     * @ORM\ManyToOne(targetEntity="Produto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produto", referencedColumnName="id")
     * })
     */
    private $produto;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Promocao", mappedBy="produtopromocional")
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
     * Set precopromocional
     *
     * @param string $precopromocional
     * @return Produtopromocional
     */
    public function setPrecopromocional($precopromocional)
    {
        $this->precopromocional = $precopromocional;

        return $this;
    }

    /**
     * Get precopromocional
     *
     * @return string 
     */
    public function getPrecopromocional()
    {
        return $this->precopromocional;
    }

    /**
     * Set produto
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Produto $produto
     * @return Produtopromocional
     */
    public function setProduto(\Camaleao\Web\BimgoBundle\Entity\Produto $produto = null)
    {
        $this->produto = $produto;

        return $this;
    }

    /**
     * Get produto
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Produto 
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * Add promocao
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Promocao $promocao
     * @return Produtopromocional
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
