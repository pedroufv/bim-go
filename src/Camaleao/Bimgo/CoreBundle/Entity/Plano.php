<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plano
 *
 * @ORM\Table(name="plano")
 * @ORM\Entity
 */
class Plano
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
     * @ORM\Column(name="nome", type="string", length=30, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=false)
     */
    private $descricao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Funcionalidade", inversedBy="plano")
     * @ORM\JoinTable(name="plano_funcionalidade",
     *   joinColumns={
     *     @ORM\JoinColumn(name="plano", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="funcionalidade", referencedColumnName="id")
     *   }
     * )
     */
    private $funcionalidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->funcionalidade = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Plano
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
     * @return Plano
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
     * Add funcionalidade
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Funcionalidade $funcionalidade
     * @return Plano
     */
    public function addFuncionalidade(\Camaleao\Bimgo\CoreBundle\Entity\Funcionalidade $funcionalidade)
    {
        $this->funcionalidade[] = $funcionalidade;

        return $this;
    }

    /**
     * Remove funcionalidade
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Funcionalidade $funcionalidade
     */
    public function removeFuncionalidade(\Camaleao\Bimgo\CoreBundle\Entity\Funcionalidade $funcionalidade)
    {
        $this->funcionalidade->removeElement($funcionalidade);
    }

    /**
     * Get funcionalidade
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFuncionalidade()
    {
        return $this->funcionalidade;
    }
}
