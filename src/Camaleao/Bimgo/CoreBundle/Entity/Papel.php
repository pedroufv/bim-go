<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Papel
 *
 * @ORM\Table(name="papel", indexes={@ORM\Index(name="pai", columns={"pai"})})
 * @ORM\Entity
 */
class Papel
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
     * @ORM\Column(name="regra", type="string", length=50, nullable=false)
     */
    private $regra;

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
     * @var integer
     *
     * @ORM\Column(name="pai", type="integer", nullable=true)
     */
    private $pai;



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
     * Set regra
     *
     * @param string $regra
     * @return Papel
     */
    public function setRegra($regra)
    {
        $this->regra = $regra;

        return $this;
    }

    /**
     * Get regra
     *
     * @return string
     */
    public function getRegra()
    {
        return $this->regra;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Papel
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
     * @return Papel
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
     * Set pai
     *
     * @param integer $pai
     * @return Papel
     */
    public function setPai($pai)
    {
        $this->pai = $pai;

        return $this;
    }

    /**
     * Get pai
     *
     * @return integer
     */
    public function getPai()
    {
        return $this->pai;
    }
}
