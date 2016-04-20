<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioInstituicaoPapel
 *
 * @ORM\Table(name="usuario_instituicao_papel", indexes={@ORM\Index(name="usuario", columns={"usuario"}), @ORM\Index(name="instituicao", columns={"instituicao"}), @ORM\Index(name="papel", columns={"papel"})})
 * @ORM\Entity
 */
class UsuarioInstituicaoPapel
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="seguindo", type="boolean", nullable=false)
     */
    private $seguindo;

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
     * @var \Papel
     *
     * @ORM\ManyToOne(targetEntity="Papel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="papel", referencedColumnName="id")
     * })
     */
    private $papel;



    /**
     * Set seguindo
     *
     * @param boolean $seguindo
     * @return UsuarioInstituicaoPapel
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

    /**
     * Set usuario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $usuario
     * @return UsuarioInstituicaoPapel
     */
    public function setUsuario(\Camaleao\Web\BimgoBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set instituicao
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Instituicao $instituicao
     * @return UsuarioInstituicaoPapel
     */
    public function setInstituicao(\Camaleao\Web\BimgoBundle\Entity\Instituicao $instituicao)
    {
        $this->instituicao = $instituicao;

        return $this;
    }

    /**
     * Get instituicao
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Instituicao 
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Set papel
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Papel $papel
     * @return UsuarioInstituicaoPapel
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
