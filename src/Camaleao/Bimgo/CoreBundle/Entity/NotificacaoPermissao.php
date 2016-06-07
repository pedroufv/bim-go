<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificacaoPermissao
 *
 * @ORM\Table(name="notificacao_permissao", indexes={@ORM\Index(name="destinatarioTipo", columns={"destinatarioTipo"}), @ORM\Index(name="mensagemTipo", columns={"mensagemTipo"}), @ORM\Index(name="papel", columns={"papel"})})
 * @ORM\Entity
 */
class NotificacaoPermissao
{
    /**
     * @var \Destinatariotipo
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Destinatariotipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinatarioTipo", referencedColumnName="id")
     * })
     */
    private $destinatariotipo;

    /**
     * @var \Mensagemtipo
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Mensagemtipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mensagemTipo", referencedColumnName="id")
     * })
     */
    private $mensagemtipo;

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
     * Set destinatariotipo
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo $destinatariotipo
     * @return NotificacaoPermissao
     */
    public function setDestinatariotipo(\Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo $destinatariotipo)
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
     * @return NotificacaoPermissao
     */
    public function setMensagemtipo(\Camaleao\Bimgo\CoreBundle\Entity\Mensagemtipo $mensagemtipo)
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

    /**
     * Set papel
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Papel $papel
     * @return NotificacaoPermissao
     */
    public function setPapel(\Camaleao\Bimgo\CoreBundle\Entity\Papel $papel)
    {
        $this->papel = $papel;

        return $this;
    }

    /**
     * Get papel
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Papel 
     */
    public function getPapel()
    {
        return $this->papel;
    }
}
