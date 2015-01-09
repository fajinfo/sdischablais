<?php

namespace Jsp\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserModType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
		->add('roles', 'choice', array(
			'choices' => array(
				'ROLE_CHAUFFEUR' => 'Chauffeur',
				'ROLE_PHOTOGRAPHE' => 'Photographe',
                'ROLE_OFFICIER' => 'Officier',
                'ROLE_QM' => 'QM',
				'ROLE_ADMIN' => 'Administrateur',
				'ROLE_SUPER_ADMIN' => 'SuperAdministrateur'
			),
			'multiple' => true))
		->add('enabled', 'checkbox')
		->add('username', 'text')
		->add('email', 'email');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jsp\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jsp_adminbundle_usermod';
    }
}
