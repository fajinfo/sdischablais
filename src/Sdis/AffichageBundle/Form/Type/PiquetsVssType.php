<?php

namespace Sdis\AffichageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PiquetsVssType extends AbstractType {
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('section', 'entity', array('class' => 'SdisAffichageBundle:Sections', 'property' => 'numero'))
                ->add('debut', 'datetime', array(
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                    'date_format' => 'dd/MM/yyyy',
                    'label' => 'De'
                ))
                ->add('fin', 'datetime', array(
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                    'date_format' => 'dd/MM/yyyy',
                    'label' => 'A'
                ))
                ->add('chauffeur1', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                    ->where('p.chauffeur = 1')
                    ->orderBy('p.nom', 'ASC');
                },
                'required' => false,))
                ->add('chauffeur2', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                    ->where('p.chauffeur = 1')
                    ->orderBy('p.nom', 'ASC');
                },
                'required' => false,));
    }
    
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Sdis\AffichageBundle\Entity\PiquetsVss'));
    }
    
    /**
    * @return string
    */
    public function getName() {
        return 'sdis_affichagebundle_piquetsvss';
    }
}
?>