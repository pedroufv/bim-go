<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reporte
 *
 */
class Reporte
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
    private $instituicao;

    /**
     * @var string
     */
    private $nomeInstituicao;

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
