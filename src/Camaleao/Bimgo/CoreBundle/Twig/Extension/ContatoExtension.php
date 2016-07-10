<?php

namespace Camaleao\Bimgo\CoreBundle\Twig\Extension;

class ContatoExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('contato', array($this, 'contatoFunction')),
        );
    }

    public function contatoFunction(\Doctrine\ORM\PersistentCollection $contatos, $type = 'Telefone')
    {
        foreach($contatos as $contato) {
            if($contato->getContatotipo()->getNome() === $type)
                return $contato->getContato();
        }

        return false;
    }

    public function getName()
    {
        return 'contato_extension';
    }
}