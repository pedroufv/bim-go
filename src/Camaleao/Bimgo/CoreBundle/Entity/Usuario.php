<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="nome", columns={"nome"}), @ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="papel", columns={"papel"})})
 * @ORM\Entity
 */
class Usuario
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
     * @ORM\Column(name="nome", type="string", length=200, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=32, nullable=false)
     */
    private $senha;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=32, nullable=false)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="registrationId", type="string", length=255, nullable=true)
     */
    private $registrationid;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo = 0;

    /**
     * @var \Papel
     *
     * @ORM\ManyToOne(targetEntity="Papel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="papel", referencedColumnName="id")
     * })
     */
    private $papel;



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
     * Set nome
     *
     * @param string $nome
     * @return Usuario
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set senha
     *
     * @param string $senha
     * @return Usuario
     */
    public function setSenha($senha)
    {
        $this->senha = md5($senha);

        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Usuario
     */
    public function setToken($token)
    {
        $this->token = md5($token);

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set registrationid
     *
     * @param string $registrationid
     * @return Usuario
     */
    public function setRegistrationid($registrationid)
    {
        $this->registrationid = $registrationid;

        return $this;
    }

    /**
     * Get registrationid
     *
     * @return string
     */
    public function getRegistrationid()
    {
        return $this->registrationid;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Usuario
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set papel
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Papel $papel
     * @return Usuario
     */
    public function setPapel(\Camaleao\Bimgo\CoreBundle\Entity\Papel $papel = null)
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
