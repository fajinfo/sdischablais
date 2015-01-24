<?php

namespace Jsp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Jsp\DynamiqueBundle\Entity\liens;
use Jsp\AdminBundle\Form\Type\LiensType;

class LiensController extends Controller
{
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function listeAction()
    {
		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('JspDynamiqueBundle:liens');
		
		$liste_liens = $repository->findAll();
        return $this->render('JspAdminBundle:Liens:liste.html.twig', array('liens' => $liste_liens));
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function supprimerAction($id)
    {
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('JspDynamiqueBundle:liens');
		
		$lien = $repository->find($id);
		
        return $this->render('JspAdminBundle:Liens:supprimer.html.twig', array('lien' => $lien));
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function supprimerOKAction($id)
    {
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspDynamiqueBundle:liens');
		
		$lien = $repository->find($id);
		$em->remove($lien);
		$em->flush();
		
        return $this->render('JspAdminBundle:Liens:supprimerSucces.html.twig');
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function nouveauAction()
	{
		$lien = new liens;
		$form = $this->createForm(new LiensType, $lien);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($lien);
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_liens_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:Liens:nouveau.html.twig', array( 'form' => $form->createView()));
	}
	
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function modifierAction($id)
	{
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspDynamiqueBundle:liens');
		
		$lien = $repository->find($id);
		$form = $this->createForm(new LiensType, $lien);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_liens_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:Liens:nouveau.html.twig', array( 'form' => $form->createView()));
	}
}
