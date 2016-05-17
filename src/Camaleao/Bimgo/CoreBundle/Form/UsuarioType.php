<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ->add('senha', PasswordType::class)
            ->add('token', HiddenType::class)
            ->add('registrationid', HiddenType::class)
            ->add('ativo', ChoiceType::class, array(
                'choices'  => array(
                    'Sim' => true,
                    'Não' => false
                ),
                'choices_as_values' => true,
            ))
            ->add('papel', EntityType::class, array(
                'class'         => 'Camaleao\Bimgo\CoreBundle\Entity\Papel',
                'label'         => 'Papel',
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
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'
        ));
    }
}
