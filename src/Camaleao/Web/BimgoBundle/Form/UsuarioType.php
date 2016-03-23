<?php

namespace Camaleao\Web\BimgoBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('email')
            ->add('senha')
            ->add('token')
            ->add('registrationid')
            ->add('ativo')
            ->add('papel', EntityType::class, array(
                'class'         => 'Camaleao\Web\BimgoBundle\Entity\Papel',
                'label'         => 'Segmento',
                'choice_label'  => function ($papel) {
                    return $papel->getNome();
                }
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Camaleao\Web\BimgoBundle\Entity\Usuario'
        ));
    }
}
