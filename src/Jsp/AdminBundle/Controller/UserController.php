<?php

namespace Jsp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Jsp\UserBundle\Entity\User;
use Jsp\AdminBundle\Form\Type\UserType;
use Jsp\AdminBundle\Form\Type\UserModType;
use Jsp\AdminBundle\Form\Type\UserChangePasswordType;

class UserController extends Controller
{
	/**
	* @Secure(roles="ROLE_SUPER_ADMIN")
	*/
    public function listeAction()
    {
		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('JspUserBundle:User');
		
		$liste_utilisateurs = $repository->findAll();
        return $this->render('JspAdminBundle:User:liste.html.twig', array('users' => $liste_utilisateurs));
    }
	/**
	* @Secure(roles="ROLE_SUPER_ADMIN")
	*/
    public function supprimerAction($id)
    {
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('JspUserBundle:User');
		
		$user = $repository->find($id);
		
        return $this->render('JspAdminBundle:User:supprimer.html.twig', array('user' => $user));
    }
	/**
	* @Secure(roles="ROLE_SUPER_ADMIN")
	*/
    public function supprimerOKAction($id)
    {
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspUserBundle:User');
		
		$user = $repository->find($id);
		$em->remove($user);
		$em->flush();
		
        return $this->render('JspAdminBundle:User:supprimerSucces.html.twig');
    }
	/**
	* @Secure(roles="ROLE_SUPER_ADMIN")
	*/
	public function nouveauAction()
	{
		$user = new User;
		$form = $this->createForm(new UserType, $user);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_user_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:User:nouveau.html.twig', array( 'form' => $form->createView()));
	}
	
	/**
	* @Secure(roles="ROLE_SUPER_ADMIN")
	*/
	public function modifierAction($id)
	{
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspUserBundle:User');
		
		$user = $repository->find($id);
		$form = $this->createForm(new UserModType, $user);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_user_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:User:modifier.html.twig', array( 'form' => $form->createView()));
	}
	/**
	* @Secure(roles="ROLE_SUPER_ADMIN")
	*/
	public function changePasswordAction($id)
	{
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspUserBundle:User');
		
		$user = $repository->find($id);
		$form = $this->createForm(new UserChangePasswordType, $user);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
					$factory = $this->get('security.encoder_factory');
					$encoder = $factory->getEncoder($user);
					$user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_user_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:User:changePassword.html.twig', array( 'form' => $form->createView()));
	}
}
