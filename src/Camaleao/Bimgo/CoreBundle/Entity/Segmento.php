<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Segmento
 *
 * @ORM\Table(name="segmento", indexes={@ORM\Index(name="icone", columns={"icone"})})
 * @ORM\Entity
 */
class Segmento
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
     * @var \Icone
     *
     * @ORM\ManyToOne(targetEntity="Icone")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="icone", referencedColumnName="id")
     * })
     */
    private $icone;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Instituicao", mappedBy="segmento", cascade={"all"})
     */
    private $instituicao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instituicao = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Segmento
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
     * @return Segmento
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
     * Set icone
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Icone $icone
     * @return Segmento
     */
    public function setIcone(\Camaleao\Bimgo\CoreBundle\Entity\Icone $icone = null)
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * Get icone
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Icone
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * Add instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Segmento
     */
    public function addInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao)
    {
        $this->instituicao[] = $instituicao;

        return $this;
    }

    /**
     * Remove instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     */
    public function removeInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao)
    {
        $this->instituicao->removeElement($instituicao);
    }

    /**
     * Get instituicao
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }
}
