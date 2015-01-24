<?php

namespace Jsp\AdminBundle\Form\Type;

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
			'class' => 'JspGalerieBundle:Galeries',
			'property' => 'titre',
			'multiple' => false,
			'required' => false));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jsp\GalerieBundle\Entity\Galeries'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jsp_adminbundle_galeries';
    }
}
