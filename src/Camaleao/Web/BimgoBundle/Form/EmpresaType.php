<?php

namespace Camaleao\Web\BimgoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpresaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('razaosocial')
            ->add('nomefantasia')
            ->add('descricao')
            ->add('cnpj')
            ->add('inscricaoestadual')
            ->add('telefone')
            ->add('usuario')
            ->add('endereco')
            ->add('grupoempresas')
            ->add('segmento')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Camaleao\Web\BimgoBundle\Entity\Empresa'
        ));
    }
}
