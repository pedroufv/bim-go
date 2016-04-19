<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensagemtipo
 *
 * @ORM\Table(name="mensagemTipo", indexes={@ORM\Index(name="papel", columns={"papel"})})
 * @ORM\Entity
 */
class Mensagemtipo
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
     * @ORM\Column(name="nome", type="string", length=50, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=50, nullable=false)
     */
    private $descricao;

    /**
     * @var \Papel
     *
     * @ORM\ManyToOne(targetEntity="Papel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="papel", referencedColumnName="id")
     * })
     */
    private $papel;



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
     * @return Mensagemtipo
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
     * @return Mensagemtipo
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
     * Set papel
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Papel $papel
     * @return Mensagemtipo
     */
    public function setPapel(\Camaleao\Web\BimgoBundle\Entity\Papel $papel = null)
    {
        $this->papel = $papel;

        return $this;
    }

    /**
     * Get papel
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Papel 
     */
    public function getPapel()
    {
        return $this->papel;
    }
}
