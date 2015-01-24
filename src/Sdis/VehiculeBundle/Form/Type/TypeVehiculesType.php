<?php
namespace Sdis\VehiculeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    
class TypeVehiculesType extends AbstractType
{
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', 'text')
        ->add('color', 'text', array('label' => 'Couleur de fond'))
        ->add('textColor', 'text', array('label' => 'Couleur du texte'));
    }
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        'data_class' => 'Sdis\VehiculeBundle\Entity\TypeVehicules'));
    }
    /**
    * @return string
    */
    public function getName()
    {
        return 'sdis_vehiculebundle_typevehicules';
    }
}