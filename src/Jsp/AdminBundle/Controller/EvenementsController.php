<?php

namespace Jsp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Jsp\DynamiqueBundle\Entity\Evenement;
use Jsp\DynamiqueBundle\Form\Type\EvenementType;

class EvenementsController extends Controller
{
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function listeAction()
    {
		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('JspDynamiqueBundle:Evenement');
		
		$liste_evenements = $repository->findBy(array(), array('date' => 'ASC'));
        return $this->render('JspAdminBundle:Evenements:liste.html.twig', array('evenements' => $liste_evenements));
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function supprimerAction($id)
    {
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('JspDynamiqueBundle:Evenement');
		
		$evenement = $repository->find($id);
		
        return $this->render('JspAdminBundle:Evenements:supprimer.html.twig', array('evenement' => $evenement));
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function supprimerOKAction($id)
    {
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspDynamiqueBundle:Evenement');
		
		$evenement = $repository->find($id);
		$em->remove($evenement);
		$em->flush();
		
        return $this->render('JspAdminBundle:Evenements:supprimerSucces.html.twig');
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function purgerAction()
    {		
        return $this->render('JspAdminBundle:Evenements:purger.html.twig');
    }
		/**
	* @Secure(roles="ROLE_ADMIN")
	*/
    public function purgerOKAction()
    {
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('JspDynamiqueBundle:Evenement');
		
		$repository->purgerEvenements();
		
        return $this->render('JspAdminBundle:Evenements:purgerSuccess.html.twig');
    }
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function nouveauAction()
	{
		$evenement = new Evenement;
		$evenement->setDate(new \DateTime());
		$evenement->setDateFin(new \DateTime());
		$form = $this->createForm(new EvenementType, $evenement);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($evenement);
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_evenements_nouveau'));
			}
		}
		
		return $this->render('JspAdminBundle:Evenements:nouveau.html.twig', array( 'form' => $form->createView()));
	}
	
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function modifierAction($id)
	{
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspDynamiqueBundle:Evenement');
		
		$evenement = $repository->find($id);
		$form = $this->createForm(new EvenementType, $evenement);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_evenements_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:Evenements:nouveau.html.twig', array( 'form' => $form->createView()));
	}
}
