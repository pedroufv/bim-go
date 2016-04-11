<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacao
 *
 * @ORM\Table(name="notificacao", indexes={@ORM\Index(name="remetente", columns={"remetente", "destinatarioTipo"}), @ORM\Index(name="destinatario", columns={"destinatarioTipo"}), @ORM\Index(name="destinatarioTipo", columns={"destinatarioTipo"}), @ORM\Index(name="mensagemTipo", columns={"mensagemTipo"}), @ORM\Index(name="IDX_5ACD938626676CDF", columns={"remetente"})})
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
     * @var string
     *
     * @ORM\Column(name="mensagem", type="text", length=65535, nullable=false)
     */
    private $mensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

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
     * @var \DestinatarioTipo
     *
     * @ORM\ManyToOne(targetEntity="DestinatarioTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinatarioTipo", referencedColumnName="id")
     * })
     */
    private $destinatarioTipo;

    /**
     * @var \MensagemTipo
     *
     * @ORM\ManyToOne(targetEntity="MensagemTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mensagemTipo", referencedColumnName="id")
     * })
     */
    private $mensagemTipo;



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
     * Set destinatarioTipo
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\DestinatarioTipo $destinatarioTipo
     * @return Notificacao
     */
    public function setDestinatarioTipo(\Camaleao\Web\BimgoBundle\Entity\DestinatarioTipo $destinatarioTipo = null)
    {
        $this->destinatarioTipo = $destinatarioTipo;

        return $this;
    }

    /**
     * Get destinatarioTipo
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\DestinatarioTipo 
     */
    public function getDestinatarioTipo()
    {
        return $this->destinatarioTipo;
    }

    /**
     * Set mensagemTipo
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\MensagemTipo $mensagemTipo
     * @return Notificacao
     */
    public function setMensagemTipo(\Camaleao\Web\BimgoBundle\Entity\MensagemTipo $mensagemTipo = null)
    {
        $this->mensagemTipo = $mensagemTipo;

        return $this;
    }

    /**
     * Get mensagemTipo
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\MensagemTipo 
     */
    public function getMensagemTipo()
    {
        return $this->mensagemTipo;
    }
}
