<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Versionamento
 *
 * @ORM\Table(name="versionamento", uniqueConstraints={@ORM\UniqueConstraint(name="versao", columns={"versao"})})
 * @ORM\Entity
 */
class Versionamento
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
     * @ORM\Column(name="versao", type="string", length=4, nullable=false)
     */
    private $versao;

    /**
     * @var string
     *
     * @ORM\Column(name="plataforma", type="string", length=7, nullable=false)
     */
    private $plataforma;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validade", type="date", nullable=true)
     */
    private $validade;

    /**
     * @var boolean
     *
     * @ORM\Column(name="atual", type="boolean", nullable=false)
     */
    private $atual;


}
