<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IndicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomeremetente')
            ->add('emailremetente', 'email')
            ->add('nomedestinatario')
            ->add('emaildestinatario', 'email')
            ->add('instituicao')
            ->add('nomeinstituicao')
            ->add('emailinstituicao')
            ->add('mensagem')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Indication'
        ));
    }
}
