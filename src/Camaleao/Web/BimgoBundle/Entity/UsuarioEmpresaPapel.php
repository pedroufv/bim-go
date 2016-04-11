<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioEmpresaPapel
 *
 * @ORM\Table(name="usuario_empresa_papel", indexes={@ORM\Index(name="idUsuario", columns={"usuario", "empresa", "papel"}), @ORM\Index(name="idEmpresa", columns={"empresa", "papel"}), @ORM\Index(name="idPapel", columns={"papel"}), @ORM\Index(name="IDX_C67D5E222265B05D", columns={"usuario"}), @ORM\Index(name="IDX_C67D5E22B8D75A50", columns={"empresa"})})
 * @ORM\Entity
 */
class UsuarioEmpresaPapel
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
     * @var \Empresa
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     * })
     */
    private $empresa;

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
     * Set usuario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $usuario
     * @return UsuarioEmpresaPapel
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
     * Set empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     * @return UsuarioEmpresaPapel
     */
    public function setEmpresa(\Camaleao\Web\BimgoBundle\Entity\Empresa $empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set papel
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Papel $papel
     * @return UsuarioEmpresaPapel
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
}
