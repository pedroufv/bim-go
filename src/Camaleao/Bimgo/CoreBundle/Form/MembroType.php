<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'))
            ->add('instituicao', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Instituicao'))
            ->add('papel', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Papel'))
            ->add('ativo')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Membro'
        ));
    }
}
