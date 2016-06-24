<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcionario
 *
 * @ORM\Table(name="funcionario", uniqueConstraints={@ORM\UniqueConstraint(name="cpf", columns={"cpf"})}, indexes={@ORM\Index(name="instituicao", columns={"instituicao"}), @ORM\Index(name="endereco", columns={"endereco"}), @ORM\Index(name="criadoPor", columns={"criadoPor", "modificadoPor"}), @ORM\Index(name="modificadoPor", columns={"modificadoPor"}), @ORM\Index(name="IDX_7510A3CF8F3195FB", columns={"criadoPor"})})
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
     * @var \Instituicao
     *
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="instituicao", referencedColumnName="id")
     * })
     */
    private $instituicao;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Contato", inversedBy="funcionario", cascade={"all"})
     * @ORM\JoinTable(name="funcionario_contato",
     *   joinColumns={
     *     @ORM\JoinColumn(name="funcionario", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="contato", referencedColumnName="id")
     *   }
     * )
     */
    private $contato;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datacriacao = new \DateTime();
        $this->contato = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set instituicao
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao
     * @return Funcionario
     */
    public function setInstituicao(\Camaleao\Bimgo\CoreBundle\Entity\Instituicao $instituicao = null)
    {
        $this->instituicao = $instituicao;

        return $this;
    }

    /**
     * Get instituicao
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Instituicao
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Set endereco
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Endereco $endereco
     * @return Funcionario
     */
    public function setEndereco(\Camaleao\Bimgo\CoreBundle\Entity\Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set criadopor
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $criadopor
     * @return Funcionario
     */
    public function setCriadopor(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $criadopor = null)
    {
        $this->criadopor = $criadopor;

        return $this;
    }

    /**
     * Get criadopor
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Usuario
     */
    public function getCriadopor()
    {
        return $this->criadopor;
    }

    /**
     * Set modificadopor
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Usuario $modificadopor
     * @return Funcionario
     */
    public function setModificadopor(\Camaleao\Bimgo\CoreBundle\Entity\Usuario $modificadopor = null)
    {
        $this->modificadopor = $modificadopor;

        return $this;
    }

    /**
     * Get modificadopor
     *
     * @return \Camaleao\Bimgo\CoreBundle\Entity\Usuario
     */
    public function getModificadopor()
    {
        return $this->modificadopor;
    }

    /**
     * Add contato
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Contato $contato
     * @return Funcionario
     */
    public function addContato(\Camaleao\Bimgo\CoreBundle\Entity\Contato $contato)
    {
        $this->contato[] = $contato;

        return $this;
    }

    /**
     * Remove contato
     *
     * @param \Camaleao\Bimgo\CoreBundle\Entity\Contato $contato
     */
    public function removeContato(\Camaleao\Bimgo\CoreBundle\Entity\Contato $contato)
    {
        $this->contato->removeElement($contato);
    }

    /**
     * Get contato
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContato()
    {
        return $this->contato;
    }
}
