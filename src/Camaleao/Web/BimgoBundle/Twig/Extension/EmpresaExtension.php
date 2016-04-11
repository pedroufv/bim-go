<?php

namespace Camaleao\Web\BimgoBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;

class EmpresaExtension extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getGlobals()
    {
        $empresas = $this->em->getRepository('CamaleaoWebBimgoBundle:Empresa')->findBy(array(), array('id' => 'DESC'), 4);

        return array(
            'empresas'=> $empresas,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'empresa_extension';
    }
}
