<?php

namespace Sdis\GalerieBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GaleriesType extends AbstractType
{
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text')
            ->add('description', 'text', array('required' => false))
            ->add('parente', 'entity', array(
                'class' => 'SdisGalerieBundle:Galeries',
                'property' => 'slug',
                'multiple' => false,
                'required' => false))
            ->add('slug', 'text');
    }
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sdis\GalerieBundle\Entity\Galeries'
        ));
    }
    /**
    * @return string
    */
    public function getName()
    {
        return 'sdis_galeriebundle_galeries';
    }
}