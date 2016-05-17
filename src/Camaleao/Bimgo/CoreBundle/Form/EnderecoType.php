<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnderecoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logradouro')
            ->add('numero')
            ->add('complemento')
            ->add('bairro')
            ->add('cep')
            ->add('cidade', EntityType::class, array(
                'class'         => 'Camaleao\Bimgo\CoreBundle\Entity\Cidade',
                'label'         => 'cidade',
                'choice_label'  => function ($cidade) {
                    return $cidade->getNome();
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
            'csrf_protection' => false,
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Endereco'
        ));
    }
}
