<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contato
 *
 * @ORM\Table(name="contato", indexes={@ORM\Index(name="tipo", columns={"contatoTipo"})})
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
     * @var \Contatotipo
     *
     * @ORM\ManyToOne(targetEntity="Contatotipo", cascade={"merge", "persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contatoTipo", referencedColumnName="id")
     * })
     */
    private $contatotipo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Funcionario", mappedBy="contato")
     */
    private $funcionario;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Instituicao", mappedBy="contato")
     */
    private $instituicao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->funcionario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set contatotipo
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Contatotipo $contatotipo
     * @return Contato
     */
    public function setContatotipo(\Camaleao\Bimgo\CoreBundle\Entity\Contatotipo $contatotipo = null)
    {
        $this->contatotipo = $contatotipo;

        return $this;
    }

    /**
     * Get contatotipo
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Contatotipo
     */
    public function getContatotipo()
    {
        return $this->contatotipo;
    }

    /**
     * Add funcionario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Funcionario $funcionario
     * @return Contato
     */
    public function addFuncionario(\Camaleao\Bimgo\CoreBundle\Entity\Funcionario $funcionario)
    {
        $this->funcionario[] = $funcionario;

        return $this;
    }

    /**
     * Remove funcionario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Funcionario $funcionario
     */
    public function removeFuncionario(\Camaleao\Bimgo\CoreBundle\Entity\Funcionario $funcionario)
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

    /**
     * Add instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Contato
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
