<?php

namespace Camaleao\Web\BimgoBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstituicaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('razaosocial', 'text', array('label' => 'Razão Social'))
            ->add('nomefantasia', 'text', array('label' => 'Nome Fantasia'))
            ->add('descricao', 'textarea', array('label' => 'Descrição'))
            ->add('cnpj')
            ->add('inscricaoestadual', 'text', array('label' => 'Inscrição Estadual'))
            ->add('site')
            ->add('grupo')
            ->add('ativo')
            ->add('criadopor', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Usuario'))
            ->add('modificadopor', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Usuario'))
            ->add('endereco', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Endereco'))
            ->add('vinculada', EntityType::class, array('class' => 'Camaleao\Web\BimgoBundle\Entity\Instituicao'))
            ->add('contato', EntityType::class, array(
                'class'         => 'Camaleao\Web\BimgoBundle\Entity\Contato',
                'label'         => 'Contato(s)',
                'multiple'      => true,
                'expanded'      => true,
                'label_attr'    => array('class' => 'fieldset checkbox-inline'),
                'choice_label'  => function ($contato) {
                    return $contato->getContato();
                }
            ))
            ->add('segmento', EntityType::class, array(
                'class'         => 'Camaleao\Web\BimgoBundle\Entity\Segmento',
                'label'         => 'Segmento(s)',
                'multiple'      => true,
                'expanded'      => true,
                'label_attr'    => array('class' => 'fieldset checkbox-inline'),
                'choice_label'  => function ($segmento) {
                    return $segmento->getNome();
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
            'data_class' => 'Camaleao\Web\BimgoBundle\Entity\Instituicao'
        ));
    }
}
