<?php

namespace Sdis\AffichageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonnelType extends AbstractType {
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('grade', 'choice', array( 'choices' => array(
                'Recr' => 'Recr', 'Sap' => 'Sap', 'App' => 'App', 'Cpl' => 'Cpl', 'Sgt' => 'Sgt', 'Sgtm' => 'Sgtm', 'Adj' => 'Adj', 'Lt' => 'Lt', 'Plt' => 'Plt', 'Cap' => 'Cap', 'Maj' => 'Maj')))
                ->add('nom', 'text')
                ->add('prenom', 'text')
                ->add('nip', 'integer', array('precision' => 0))
                ->add('chauffeur', 'checkbox', array('required' => false,))
				->add('section', 'entity', array('class' => 'Sdis\AffichageBundle\Entity\Sections', 'property' => 'numero', 'multiple' => false, 'required' => false));
    }
    
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Sdis\AffichageBundle\Entity\Personnel'));
    }
    
    /**
    * @return string
    */
    public function getName() {
        return 'sdis_affichagebundle_personnel';
    }
}
?>