<?php

namespace Camaleao\Web\BimgoBundle\Entity;

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
     * @ORM\ManyToMany(targetEntity="Empresa", inversedBy="segmento")
     * @ORM\JoinTable(name="segmento_empresa",
     *   joinColumns={
     *     @ORM\JoinColumn(name="segmento", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     *   }
     * )
     */
    private $empresa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empresa = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Camaleao\Web\BimgoBundle\Entity\Icone $icone
     * @return Segmento
     */
    public function setIcone(\Camaleao\Web\BimgoBundle\Entity\Icone $icone = null)
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * Get icone
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Icone 
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * Add empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     * @return Segmento
     */
    public function addEmpresa(\Camaleao\Web\BimgoBundle\Entity\Empresa $empresa)
    {
        $this->empresa[] = $empresa;

        return $this;
    }

    /**
     * Remove empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     */
    public function removeEmpresa(\Camaleao\Web\BimgoBundle\Entity\Empresa $empresa)
    {
        $this->empresa->removeElement($empresa);
    }

    /**
     * Get empresa
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
