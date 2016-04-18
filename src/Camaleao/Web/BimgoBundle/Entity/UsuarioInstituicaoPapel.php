<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioInstituicaoPapel
 *
 * @ORM\Table(name="usuario_instituicao_papel", indexes={@ORM\Index(name="idUsuario", columns={"usuario", "instituicao", "papel"}), @ORM\Index(name="idEmpresa", columns={"instituicao", "papel"}), @ORM\Index(name="idPapel", columns={"papel"}), @ORM\Index(name="IDX_EA8BB57F2265B05D", columns={"usuario"}), @ORM\Index(name="IDX_EA8BB57F7CFF8F69", columns={"instituicao"})})
 * @ORM\Entity
 */
class UsuarioInstituicaoPapel
{
    /**
     * @var \Papel
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Papel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="papel", referencedColumnName="id")
     * })
     */
    private $papel;

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
     * Set papel
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Papel $papel
     * @return UsuarioInstituicaoPapel
     */
    public function setPapel(\Camaleao\Web\BimgoBundle\Entity\Papel $papel)
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
}
