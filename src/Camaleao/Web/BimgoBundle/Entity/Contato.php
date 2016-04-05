<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contato
 *
 * @ORM\Table(name="contato", indexes={@ORM\Index(name="tipo", columns={"tipo"})})
 * @ORM\Entity
 */
class Contato
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
     * @ORM\Column(name="contato", type="string", length=200, nullable=false)
     */
    private $contato;

    /**
     * @var \ContatoTipo
     *
     * @ORM\ManyToOne(targetEntity="ContatoTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo", referencedColumnName="id")
     * })
     */
    private $tipo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Empresa", mappedBy="contato")
     */
    private $empresa;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Funcionario", mappedBy="contato")
     */
    private $funcionario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empresa = new \Doctrine\Common\Collections\ArrayCollection();
        $this->funcionario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set contato
     *
     * @param string $contato
     * @return Contato
     */
    public function setContato($contato)
    {
        $this->contato = $contato;

        return $this;
    }

    /**
     * Get contato
     *
     * @return string 
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Set tipo
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\ContatoTipo $tipo
     * @return Contato
     */
    public function setTipo(\Camaleao\Web\BimgoBundle\Entity\ContatoTipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\ContatoTipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Add empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     * @return Contato
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

    /**
     * Add funcionario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Funcionario $funcionario
     * @return Contato
     */
    public function addFuncionario(\Camaleao\Web\BimgoBundle\Entity\Funcionario $funcionario)
    {
        $this->funcionario[] = $funcionario;

        return $this;
    }

    /**
     * Remove funcionario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Funcionario $funcionario
     */
    public function removeFuncionario(\Camaleao\Web\BimgoBundle\Entity\Funcionario $funcionario)
    {
        $this->funcionario->removeElement($funcionario);
    }

    /**
     * Get funcionario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
