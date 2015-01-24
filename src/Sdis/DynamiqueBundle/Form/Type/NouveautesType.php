<?php

namespace Sdis\DynamiqueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NouveautesType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', 'text');
    }
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    $resolver->setDefaults(array(
    'data_class' => 'Sdis\DynamiqueBundle\Entity\Nouveautes'
    ));
    }
    /**
    * @return string
    */
    public function getName()
    {
        return 'sdis_dynamiquebundle_nouveautes';
    }
}