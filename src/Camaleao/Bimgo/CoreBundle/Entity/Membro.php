<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membro
 *
 * @ORM\Table(name="membro", indexes={@ORM\Index(name="usuario", columns={"usuario"}), @ORM\Index(name="instituicao", columns={"instituicao"}), @ORM\Index(name="papel", columns={"papel"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\MembroRepository")
 */
class Membro
{
    /**
     * @var \Usuario
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="membro")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @var \Instituicao
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Instituicao", inversedBy="membro")
     * @ORM\JoinColumn(name="instituicao", referencedColumnName="id", nullable=false)
     */
    private $instituicao;

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
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo = true;



    /**
     * Set usuario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario
     * @return Membro
     */
    public function setUsuario(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Membro
     */
    public function setInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao)
    {
        $this->instituicao = $instituicao;

        return $this;
    }

    /**
     * Get instituicao
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Instituicao 
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Set papel
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Papel $papel
     * @return Membro
     */
    public function setPapel(\Camaleao\Bimgo\CoreBundle\Entity\Papel $papel = null)
    {
        $this->papel = $papel;

        return $this;
    }

    /**
     * Get papel
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Papel 
     */
    public function getPapel()
    {
        return $this->papel;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Instituicao
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }
}
