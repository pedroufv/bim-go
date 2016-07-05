<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PontuacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pontos')
            ->add('usuario', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'))
            ->add('instituicao', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Instituicao'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Pontuacao'
        ));
    }
}
