<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seguidor
 *
 * @ORM\Table(name="seguidor", indexes={@ORM\Index(name="usuario", columns={"usuario"}), @ORM\Index(name="instituicao", columns={"instituicao"}) })
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\SeguidorRepository")
 */
class Seguidor
{
    /**
     * @var \Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \Instituicao
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Instituicao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     * })
     */
    private $instituicao;

    /**
     * @var boolean
     *
     * @ORM\Column(name="seguindo", type="boolean", nullable=false)
     */
    private $seguindo = false;


    /**
     * Set usuario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario
     * @return Seguidor
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
     * @return Seguidor
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
     * Set seguindo
     *
     * @param boolean $seguindo
     *
     * @return Seguidor
     */
    public function setSeguindo($seguindo)
    {
        $this->seguindo = $seguindo;

        return $this;
    }

    /**
     * Get seguindo
     *
     * @return boolean
     */
    public function getSeguindo()
    {
        return $this->seguindo;
    }
}
