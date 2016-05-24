<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcionalidade
 *
 * @ORM\Table(name="funcionalidade")
 * @ORM\Entity
 */
class Funcionalidade
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
     * @ORM\Column(name="nome", type="string", length=100, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    private $descricao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plano", mappedBy="funcionalidade")
     */
    private $plano;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plano = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Funcionalidade
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
     * @return Funcionalidade
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
     * Add plano
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Plano $plano
     * @return Funcionalidade
     */
    public function addPlano(\Camaleao\Bimgo\CoreBundle\Entity\Plano $plano)
    {
        $this->plano[] = $plano;

        return $this;
    }

    /**
     * Remove plano
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Plano $plano
     */
    public function removePlano(\Camaleao\Bimgo\CoreBundle\Entity\Plano $plano)
    {
        $this->plano->removeElement($plano);
    }

    /**
     * Get plano
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlano()
    {
        return $this->plano;
    }
}
