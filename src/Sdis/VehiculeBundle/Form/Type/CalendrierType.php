<?php
namespace Sdis\VehiculeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    
class CalendrierType extends AbstractType
{
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nomChauffeur', 'text', array('label' => 'Nom'))
        ->add('dateDebut', 'datetime', array(
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
            'date_format' => 'dd/MM/yyyy',
            'label' => 'De'
        ))
        ->add('dateFin', 'datetime', array(
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
            'date_format' => 'dd/MM/yyyy',
            'label' => 'A'
        ))
        ->add('vhc', 'entity', array(
            'class' => 'SdisVehiculeBundle:TypeVehicules',
            'property' => 'nom',
            'multiple' => false,
            'label' => 'Véhicule'
        ))
        ->add('remarque', 'text');
    }
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        'data_class' => 'Sdis\VehiculeBundle\Entity\Calendrier'));
    }
    /**
    * @return string
    */
    public function getName()
    {
        return 'sdis_vehiculebundle_calendrier';
    }
}