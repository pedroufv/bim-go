<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcionario
 *
 * @ORM\Table(name="funcionario", uniqueConstraints={@ORM\UniqueConstraint(name="cpf", columns={"cpf"})}, indexes={@ORM\Index(name="empresa", columns={"empresa"}), @ORM\Index(name="endereco", columns={"endereco"}), @ORM\Index(name="criadoPor", columns={"criadoPor", "modificadoPor"}), @ORM\Index(name="modificadoPor", columns={"modificadoPor"}), @ORM\Index(name="IDX_7510A3CF8F3195FB", columns={"criadoPor"})})
 * @ORM\Entity
 */
class Funcionario
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
     * @ORM\Column(name="cpf", type="string", length=11, nullable=false)
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=50, nullable=false)
     */
    private $telefone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriacao", type="datetime", nullable=false)
     */
    private $datacriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataModificacao", type="datetime", nullable=false)
     */
    private $datamodificacao;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     * })
     */
    private $empresa;

    /**
     * @var \Endereco
     *
     * @ORM\ManyToOne(targetEntity="Endereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endereco", referencedColumnName="id")
     * })
     */
    private $endereco;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="criadoPor", referencedColumnName="id")
     * })
     */
    private $criadopor;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modificadoPor", referencedColumnName="id")
     * })
     */
    private $modificadopor;



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
     * @return Funcionario
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
     * Set cpf
     *
     * @param string $cpf
     * @return Funcionario
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get cpf
     *
     * @return string 
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return Funcionario
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set datacriacao
     *
     * @param \DateTime $datacriacao
     * @return Funcionario
     */
    public function setDatacriacao($datacriacao)
    {
        $this->datacriacao = $datacriacao;

        return $this;
    }

    /**
     * Get datacriacao
     *
     * @return \DateTime 
     */
    public function getDatacriacao()
    {
        return $this->datacriacao;
    }

    /**
     * Set datamodificacao
     *
     * @param \DateTime $datamodificacao
     * @return Funcionario
     */
    public function setDatamodificacao($datamodificacao)
    {
        $this->datamodificacao = $datamodificacao;

        return $this;
    }

    /**
     * Get datamodificacao
     *
     * @return \DateTime 
     */
    public function getDatamodificacao()
    {
        return $this->datamodificacao;
    }

    /**
     * Set empresa
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Empresa $empresa
     * @return Funcionario
     */
    public function setEmpresa(\Camaleao\Web\BimgoBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set endereco
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Endereco $endereco
     * @return Funcionario
     */
    public function setEndereco(\Camaleao\Web\BimgoBundle\Entity\Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Endereco 
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set criadopor
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $criadopor
     * @return Funcionario
     */
    public function setCriadopor(\Camaleao\Web\BimgoBundle\Entity\Usuario $criadopor = null)
    {
        $this->criadopor = $criadopor;

        return $this;
    }

    /**
     * Get criadopor
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getCriadopor()
    {
        return $this->criadopor;
    }

    /**
     * Set modificadopor
     *
     * @param \Camaleao\Web\BimgoBundle\Entity\Usuario $modificadopor
     * @return Funcionario
     */
    public function setModificadopor(\Camaleao\Web\BimgoBundle\Entity\Usuario $modificadopor = null)
    {
        $this->modificadopor = $modificadopor;

        return $this;
    }

    /**
     * Get modificadopor
     *
     * @return \Camaleao\Web\BimgoBundle\Entity\Usuario 
     */
    public function getModificadopor()
    {
        return $this->modificadopor;
    }
}
