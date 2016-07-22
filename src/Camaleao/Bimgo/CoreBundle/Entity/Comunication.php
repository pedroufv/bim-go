<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comunication
 *
 */
class Comunication
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
    private $categoria;

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
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param string $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
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
