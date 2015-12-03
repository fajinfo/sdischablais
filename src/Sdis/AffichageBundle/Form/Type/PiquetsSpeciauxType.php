<?php

namespace Sdis\AffichageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PiquetsSpeciauxType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('debut', 'date', array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'label' => 'Du'
        ))
            ->add('fin', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'A'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Sdis\AffichageBundle\Entity\PiquetsSpeciaux'));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sdis_affichagebundle_piquetsspeciaux';
    }
}
?>