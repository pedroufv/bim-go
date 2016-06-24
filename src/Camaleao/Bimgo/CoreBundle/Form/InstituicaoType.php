<?php

namespace Camaleao\Bimgo\CoreBundle\Form;

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
            ->add('criadopor', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'))
            ->add('modificadopor', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Usuario'))
            ->add('endereco', new EnderecoType())
            ->add('vinculada', EntityType::class, array('class' => 'Camaleao\Bimgo\CoreBundle\Entity\Instituicao'))
            ->add('associada')
            ->add('contato')
            ->add('segmento')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Camaleao\Bimgo\CoreBundle\Entity\Instituicao'
        ));
    }
}
