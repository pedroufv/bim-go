<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacao
 *
 * @ORM\Table(name="notificacao", indexes={@ORM\Index(name="remetente", columns={"remetente", "destinatarioTipo"}), @ORM\Index(name="destinatario", columns={"destinatarioTipo"}), @ORM\Index(name="tipo_destinatario", columns={"destinatarioTipo"}), @ORM\Index(name="tipo_mensagem", columns={"mensagemTipo"}), @ORM\Index(name="instituicao", columns={"instituicao"}), @ORM\Index(name="IDX_5ACD938626676CDF", columns={"remetente"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\NotificacaoRepository")
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
     * @var \Instituicao
     *
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     * })
     */
    private $instituicao;

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
     * Set instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Notificacao
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

    /**
     * Set remetente
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $remetente
     * @return Notificacao
     */
    public function setRemetente(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $remetente = null)
    {
        $this->remetente = $remetente;

        return $this;
    }

    /**
     * Get remetente
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Usuario
     */
    public function getRemetente()
    {
        return $this->remetente;
    }

    /**
     * Set destinatariotipo
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo $destinatariotipo
     * @return Notificacao
     */
    public function setDestinatariotipo(\Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo $destinatariotipo = null)
    {
        $this->destinatariotipo = $destinatariotipo;

        return $this;
    }

    /**
     * Get destinatariotipo
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo
     */
    public function getDestinatariotipo()
    {
        return $this->destinatariotipo;
    }

    /**
     * Set mensagemtipo
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Mensagemtipo $mensagemtipo
     * @return Notificacao
     */
    public function setMensagemtipo(\Camaleao\Bimgo\CoreBundle\Entity\Mensagemtipo $mensagemtipo = null)
    {
        $this->mensagemtipo = $mensagemtipo;

        return $this;
    }

    /**
     * Get mensagemtipo
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Mensagemtipo
     */
    public function getMensagemtipo()
    {
        return $this->mensagemtipo;
    }
}
