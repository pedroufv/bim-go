<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Android
 *
 * @ORM\Table(name="android", uniqueConstraints={@ORM\UniqueConstraint(name="versao", columns={"versao"})})
 * @ORM\Entity
 */
class Android
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
