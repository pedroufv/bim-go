<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacao
 *
 * @ORM\Table(name="notificacao", indexes={@ORM\Index(name="remetente", columns={"remetente", "destinatarioTipo"}), @ORM\Index(name="destinatario", columns={"destinatarioTipo"}), @ORM\Index(name="tipo_destinatario", columns={"destinatarioTipo"}), @ORM\Index(name="tipo_mensagem", columns={"mensagemTipo"}), @ORM\Index(name="empresa", columns={"empresa"}), @ORM\Index(name="IDX_5ACD938626676CDF", columns={"remetente"})})
 * @ORM\Entity
 */
class Notificacao
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
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="mensagem", type="text", length=65535, nullable=false)
     */
    private $mensagem;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="remetente", referencedColumnName="id")
     * })
     */
    private $remetente;

    /**
     * @var \Destinatariotipo
     *
     * @ORM\ManyToOne(targetEntity="Destinatariotipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinatarioTipo", referencedColumnName="id")
     * })
     */
    private $destinatariotipo;

    /**
     * @var \Mensagemtipo
     *
     * @ORM\ManyToOne(targetEntity="Mensagemtipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mensagemTipo", referencedColumnName="id")
     * })
     */
    private $mensagemtipo;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     * })
     */
    private $empresa;



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
     * Set data
     *
     * @param \DateTime $data
     * @return Notificacao
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
     * Set mensagem
     *
     * @param string $mensagem
     * @return Notificacao
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get mensagem
     *
     * @return string 
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * Set remetente
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $remetente
     * @return Notificacao
     */
    public function setRemetente(\Camaleao\Web\BimgoBundle\Entity\Usuario $remetente = null)
    {
        $this->remetente = $remetente;

        return $this;
    }

    /**
     * Get remetente
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getRemetente()
    {
        return $this->remetente;
    }

    /**
     * Set destinatariotipo
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Destinatariotipo $destinatariotipo
     * @return Notificacao
     */
    public function setDestinatariotipo(\Camaleao\Web\BimgoBundle\Entity\Destinatariotipo $destinatariotipo = null)
    {
        $this->destinatariotipo = $destinatariotipo;

        return $this;
    }

    /**
     * Get destinatariotipo
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Destinatariotipo 
     */
    public function getDestinatariotipo()
    {
        return $this->destinatariotipo;
    }

    /**
     * Set mensagemtipo
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Mensagemtipo $mensagemtipo
     * @return Notificacao
     */
    public function setMensagemtipo(\Camaleao\Web\BimgoBundle\Entity\Mensagemtipo $mensagemtipo = null)
    {
        $this->mensagemtipo = $mensagemtipo;

        return $this;
    }

    /**
     * Get mensagemtipo
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Mensagemtipo 
     */
    public function getMensagemtipo()
    {
        return $this->mensagemtipo;
    }

    /**
     * Set empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     * @return Notificacao
     */
    public function setEmpresa(\Camaleao\Web\BimgoBundle\Entity\Empresa $empresa = null)
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
}
