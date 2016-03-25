<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioEmpresaPapel
 *
 * @ORM\Table(name="usuario_empresa_papel", indexes={@ORM\Index(name="idUsuario", columns={"idUsuario", "idEmpresa", "idPapel"}), @ORM\Index(name="idEmpresa", columns={"idEmpresa", "idPapel"}), @ORM\Index(name="idPapel", columns={"idPapel"}), @ORM\Index(name="IDX_C67D5E22A86E31A2", columns={"idEmpresa"}), @ORM\Index(name="IDX_C67D5E2232DCDBAF", columns={"idUsuario"})})
 * @ORM\Entity
 */
class UsuarioEmpresaPapel
{
    /**
     * @var \Endereco
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Endereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmpresa", referencedColumnName="id")
     * })
     */
    private $idempresa;

    /**
     * @var \Papel
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Papel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPapel", referencedColumnName="id")
     * })
     */
    private $idpapel;

    /**
     * @var \Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="id")
     * })
     */
    private $idusuario;



    /**
     * Set idempresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Endereco $idempresa
     * @return UsuarioEmpresaPapel
     */
    public function setIdempresa(\Camaleao\Web\BimgoBundle\Entity\Endereco $idempresa)
    {
        $this->idempresa = $idempresa;

        return $this;
    }

    /**
     * Get idempresa
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Endereco 
     */
    public function getIdempresa()
    {
        return $this->idempresa;
    }

    /**
     * Set idpapel
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Papel $idpapel
     * @return UsuarioEmpresaPapel
     */
    public function setIdpapel(\Camaleao\Web\BimgoBundle\Entity\Papel $idpapel)
    {
        $this->idpapel = $idpapel;

        return $this;
    }

    /**
     * Get idpapel
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Papel 
     */
    public function getIdpapel()
    {
        return $this->idpapel;
    }

    /**
     * Set idusuario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $idusuario
     * @return UsuarioEmpresaPapel
     */
    public function setIdusuario(\Camaleao\Web\BimgoBundle\Entity\Usuario $idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}
