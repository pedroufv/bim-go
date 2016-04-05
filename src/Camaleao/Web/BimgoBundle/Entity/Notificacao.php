<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacao
 *
 * @ORM\Table(name="notificacao", indexes={@ORM\Index(name="remetente", columns={"remetente", "tipo_destinatario"}), @ORM\Index(name="destinatario", columns={"tipo_destinatario"}), @ORM\Index(name="tipo_destinatario", columns={"tipo_destinatario"}), @ORM\Index(name="tipo_mensagem", columns={"tipo_mensagem"}), @ORM\Index(name="IDX_5ACD938626676CDF", columns={"remetente"})})
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
     *   @ORM\JoinColumn(name="tipo_destinatario", referencedColumnName="id")
     * })
     */
    private $tipoDestinatario;

    /**
     * @var \MensagemTipo
     *
     * @ORM\ManyToOne(targetEntity="MensagemTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_mensagem", referencedColumnName="id")
     * })
     */
    private $tipoMensagem;



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
     * Set tipoDestinatario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\DestinatarioTipo $tipoDestinatario
     * @return Notificacao
     */
    public function setTipoDestinatario(\Camaleao\Web\BimgoBundle\Entity\DestinatarioTipo $tipoDestinatario = null)
    {
        $this->tipoDestinatario = $tipoDestinatario;

        return $this;
    }

    /**
     * Get tipoDestinatario
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\DestinatarioTipo 
     */
    public function getTipoDestinatario()
    {
        return $this->tipoDestinatario;
    }

    /**
     * Set tipoMensagem
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\MensagemTipo $tipoMensagem
     * @return Notificacao
     */
    public function setTipoMensagem(\Camaleao\Web\BimgoBundle\Entity\MensagemTipo $tipoMensagem = null)
    {
        $this->tipoMensagem = $tipoMensagem;

        return $this;
    }

    /**
     * Get tipoMensagem
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\MensagemTipo 
     */
    public function getTipoMensagem()
    {
        return $this->tipoMensagem;
    }
}
