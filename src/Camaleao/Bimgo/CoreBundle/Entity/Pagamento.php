<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pagamento
 *
 * @ORM\Table(name="pagamento", indexes={@ORM\Index(name="instituicao", columns={"instituicao"})})
 * @ORM\Entity
 */
class Pagamento
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
     * @var integer
     *
     * @ORM\Column(name="quantidade", type="integer", nullable=false)
     */
    private $quantidade;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=2, nullable=false)
     */
    private $valor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataInicio", type="date", nullable=false)
     */
    private $datainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataFim", type="date", nullable=false)
     */
    private $datafim;

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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return Pagamento
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valor
     *
     * @param float $valor
     * @return Pagamento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set datainicio
     *
     * @param \DateTime $datainicio
     * @return Pagamento
     */
    public function setDatainicio($datainicio)
    {
        $this->datainicio = $datainicio;

        return $this;
    }

    /**
     * Get datainicio
     *
     * @return \DateTime
     */
    public function getDatainicio()
    {
        return $this->datainicio;
    }

    /**
     * Set datafim
     *
     * @param \DateTime $datafim
     * @return Pagamento
     */
    public function setDatafim($datafim)
    {
        $this->datafim = $datafim;

        return $this;
    }

    /**
     * Get datafim
     *
     * @return \DateTime
     */
    public function getDatafim()
    {
        return $this->datafim;
    }

    /**
     * Set instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Pagamento
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
