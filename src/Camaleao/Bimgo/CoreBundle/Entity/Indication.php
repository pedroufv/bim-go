<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indication
 *
 */
class Indication
{
    /**
     * @var string
     */
    private $nomeRemetente;

    /**
     * @var string
     */
    private $emailRemetente;

    /**
     * @var string
     */
    private $nomeDestinatario;

    /**
     * @var string
     */
    private $emailDestinatario;

    /**
     * @var string
     */
    private $instituicao;

    /**
     * @var string
     */
    private $nomeInstituicao;

    /**
     * @var string
     */
    private $mensagem;

    /**
     * @return string
     */
    public function getNomeRemetente()
    {
        return $this->nomeRemetente;
    }

    /**
     * @param string $nomeRemetente
     */
    public function setNomeRemetente($nomeRemetente)
    {
        $this->nomeRemetente = $nomeRemetente;
    }

    /**
     * @return string
     */
    public function getEmailRemetente()
    {
        return $this->emailRemetente;
    }

    /**
     * @param string $emailRemetente
     */
    public function setEmailRemetente($emailRemetente)
    {
        $this->emailRemetente = $emailRemetente;
    }

    /**
     * @return string
     */
    public function getNomeDestinatario()
    {
        return $this->nomeDestinatario;
    }

    /**
     * @param string $nomeDestinatario
     */
    public function setNomeDestinatario($nomeDestinatario)
    {
        $this->nomeDestinatario = $nomeDestinatario;
    }

    /**
     * @return string
     */
    public function getEmailDestinatario()
    {
        return $this->emailDestinatario;
    }

    /**
     * @param string $emailDestinatario
     */
    public function setEmailDestinatario($emailDestinatario)
    {
        $this->emailDestinatario = $emailDestinatario;
    }

    /**
     * @return string
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * @param string $instituicao
     */
    public function setInstituicao($instituicao)
    {
        $this->instituicao = $instituicao;
    }

    /**
     * @return string
     */
    public function getNomeInstituicao()
    {
        return $this->nomeInstituicao;
    }

    /**
     * @param string $nomeInstituicao
     */
    public function setNomeInstituicao($nomeInstituicao)
    {
        $this->nomeInstituicao = $nomeInstituicao;
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }
}
