<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacao
 *
 * @ORM\Table(name="notificacao", indexes={@ORM\Index(name="remetente", columns={"remetente", "destinatario"}), @ORM\Index(name="destinatario", columns={"destinatario"}), @ORM\Index(name="IDX_5ACD938626676CDF", columns={"remetente"})})
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
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinatario", referencedColumnName="id")
     * })
     */
    private $destinatario;

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
     * Set destinatario
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $destinatario
     * @return Notificacao
     */
    public function setDestinatario(\Camaleao\Web\BimgoBundle\Entity\Usuario $destinatario = null)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getDestinatario()
    {
        return $this->destinatario;
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
}
