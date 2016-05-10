<?php

namespace Camaleao\Web\BimgoBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromocaoType extends AbstractType
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
            ->add('datainicio', 'date')
            ->add('datafim', 'date')
            ->add('publicada')
            ->add('instituicao', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Instituicao'))
            ->add('criadopor', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Usuario'))
            ->add('modificadopor', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Usuario'))
            ->add('oferta')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Camaleao\Web\BimgoBundle\Entity\Promocao'
        ));
    }
}
