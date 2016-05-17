<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oferta
 *
 * @ORM\Table(name="oferta", indexes={@ORM\Index(name="produto", columns={"produto"})})
 * @ORM\Entity
 */
class Oferta
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
     * @ORM\ManyToMany(targetEntity="Promocao", inversedBy="oferta")
     * @ORM\JoinTable(name="promocao_oferta",
     *   joinColumns={
     *     @ORM\JoinColumn(name="oferta", referencedColumnName="id")
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
     * Set precopromocional
     *
     * @param string $precopromocional
     * @return Oferta
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
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Produto $produto
     * @return Oferta
     */
    public function setProduto(\Camaleao\Bimgo\CoreBundle\Entity\Produto $produto = null)
    {
        $this->produto = $produto;

        return $this;
    }

    /**
     * Get produto
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * Add promocao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Promocao $promocao
     * @return Oferta
     */
    public function addPromocao(\Camaleao\Bimgo\CoreBundle\Entity\Promocao $promocao)
    {
        $this->promocao[] = $promocao;

        return $this;
    }

    /**
     * Remove promocao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Promocao $promocao
     */
    public function removePromocao(\Camaleao\Bimgo\CoreBundle\Entity\Promocao $promocao)
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
