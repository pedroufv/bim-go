<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FuncionarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('cpf')
            ->add('instituicao', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Instituicao'))
            ->add('endereco', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Endereco'))
            ->add('criadopor', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'))
            ->add('modificadopor', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'))
            ->add('contato')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Funcionario'
        ));
    }
}
