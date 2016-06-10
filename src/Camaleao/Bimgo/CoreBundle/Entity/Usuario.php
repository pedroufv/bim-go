<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="nome", columns={"nome"}), @ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity(repositoryClass="Camaleao\Bimgo\CoreBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
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
     * @ORM\Column(name="administrador", type="boolean", nullable=false)
     */
    private $administrador = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo = true;

    /**
     * @ORM\OneToMany(targetEntity="Membro", mappedBy="usuario")
     */
    private $membro;

    /**
     * @ORM\OneToMany(targetEntity="Seguidor", mappedBy="usuario")
     */
    private $seguidor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->membro = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seguidor = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
        $this->senha = $senha;

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
        $this->token = $token;

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
     * Set administrador
     *
     * @param boolean $administrador
     * @return Usuario
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return boolean
     */
    public function getAdministrador()
    {
        return $this->administrador;
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
     * Get Membro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembro()
    {
        return $this->membro;
    }

    /**
     * Get Active Membro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveMembro($ativo = true)
    {
        return $this->membro->filter(
            function($entry) use ($ativo) {
                /**
                 * @var Membro $entry
                 */
                return $entry->getAtivo() === $ativo;
            }
        );
    }

    /**
     * Get Active Membros by papel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveMembroByPapel($papel)
    {
        return $this->getActiveMembro()->filter(
            function($entry) use ($papel) {
                /**
                 * @var Membro $entry
                 */
                return $entry->getPapel()->getId() == $papel;
            }
        );
    }

    /**
     * Get Seguidor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguidor()
    {
        return $this->seguidor;
    }

    /**
     * Get Seguindo Seguidor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguindoSeguidor($seguindo = true)
    {
        return $this->seguidor->filter(
            function($entry) use ($seguindo) {
                /**
                 * @var Seguidor $entry
                 */
                return $entry->getSeguindo() === $seguindo;
            }
        );
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * return (Role|string)[] The user roles
     *
     * @return array
     *
     * TODO: verificar se o usuario é cliente administrador
     */
    public function getRoles()
    {
        if($this->getAdministrador())
            return array('ROLE_ADMINISTRADOR');

        return array('ROLE_CLIENTE');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() { return $this->getSenha(); }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() { return null; }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() { return $this->getEmail(); }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() { }
}
