<?php

namespace Camaleao\Web\BimgoBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpresaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('razaosocial')
            ->add('nomefantasia')
            ->add('descricao')
            ->add('cnpj')
            ->add('inscricaoestadual')
            ->add('telefone')
            ->add('usuario', new UsuarioType())
            ->add('endereco', new EnderecoType())
            ->add('grupoempresas', EntityType::class, array(
                'class'         => 'Camaleao\Web\BimgoBundle\Entity\Grupoempresas',
                'label'         => 'Grupo Empresas',
                'choice_label'  => function ($grupoempresas) {
                    return $grupoempresas->getNome();
                }
            ))
            ->add('segmento', EntityType::class, array(
                'class'         => 'Camaleao\Web\BimgoBundle\Entity\Segmento',
                'label'         => 'Segmento',
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
            'data_class' => 'Camaleao\Web\BimgoBundle\Entity\Empresa'
        ));
    }
}
