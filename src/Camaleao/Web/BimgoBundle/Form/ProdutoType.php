<?php

namespace Camaleao\Web\BimgoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProdutoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('descricao')
            ->add('ean')
            ->add('preco')
            ->add('datacriado')
            ->add('datamodificacao')
            ->add('instituicao')
            ->add('criadopor')
            ->add('modificadopor')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'cascade_validation' => false,
            'data_class' => 'Camaleao\Web\BimgoBundle\Entity\Produto'
        ));
    }
}
