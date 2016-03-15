<?php

namespace Camaleao\Web\BimgoBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;

class PromocaoExtension extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getGlobals()
    {
        $promocoes = $this->em->getRepository('CamaleaoWebBimgoBundle:Promocao')->findBy(array(), array('id' => 'DESC'), 5);

        return array(
            'promocoes'=> $promocoes,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'promocao_extension';
    }
}
