<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historico
 *
 * @ORM\Table(name="historico", indexes={@ORM\Index(name="usuario", columns={"usuario"}), @ORM\Index(name="instituicao", columns={"instituicao"})})
 * @ORM\Entity
 */
class Historico
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
     * @ORM\Column(name="valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="detalhamento", type="string", length=60, nullable=true)
     */
    private $detalhamento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="operacao", type="boolean", nullable=false)
     */
    private $operacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="pontos", type="integer", nullable=false)
     */
    private $pontos;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return Historico
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set detalhamento
     *
     * @param string $detalhamento
     * @return Historico
     */
    public function setDetalhamento($detalhamento)
    {
        $this->detalhamento = $detalhamento;

        return $this;
    }

    /**
     * Get detalhamento
     *
     * @return string 
     */
    public function getDetalhamento()
    {
        return $this->detalhamento;
    }

    /**
     * Set operacao
     *
     * @param boolean $operacao
     * @return Historico
     */
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;

        return $this;
    }

    /**
     * Get operacao
     *
     * @return boolean 
     */
    public function getOperacao()
    {
        return $this->operacao;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     * @return Historico
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set pontos
     *
     * @param integer $pontos
     * @return Historico
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
     * @return Historico
     */
    public function setUsuario(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $usuario = null)
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
     * @return Historico
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
