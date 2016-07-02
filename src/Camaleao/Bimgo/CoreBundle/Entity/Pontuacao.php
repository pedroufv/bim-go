<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pontuacao
 *
 * @ORM\Table(name="pontuacao", indexes={@ORM\Index(name="usuario", columns={"usuario"}), @ORM\Index(name="instituicao", columns={"instituicao"})})
 * @ORM\Entity
 */
class Pontuacao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pontos", type="integer", nullable=false)
     */
    private $pontos;

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
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     * })
     */
    private $instituicao;



    /**
     * Set pontos
     *
     * @param integer $pontos
     * @return Pontuacao
     */
    public function setPontos($pontos)
    {
        $this->pontos = $pontos;

        return $this;
    }

    /**
     * Get pontos
     *
     * @return integer 
     */
    public function getPontos()
    {
        return $this->pontos;
    }

    /**
     * Set usuario
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario
     * @return Pontuacao
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
     * @return Pontuacao
     */
    public function setInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao = null)
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
}
