<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\Personnel;
use Sdis\AffichageBundle\Form\Type\PersonnelType;

class PersonnelController extends Controller
{
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function listeAction() {		
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:Personnel');
        $personnels = $repository->findby(array(), array('nom' => 'ASC'));    
            
        return $this->render('SdisAffichageBundle:Personnel:liste.html.twig', array('personnels' => $personnels));
    }
	/**
    * @Secure(roles="ROLE_ADMIN")
    */
	public function supprimerAction(Personnel $personnel) {
		return $this->render('SdisAffichageBundle:Personnel:supprimer.html.twig', array('personnel' => $personnel));
	}
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function supprimerOkAction(Personnel $personnel) {		
		$em = $this->getDoctrine()->getManager();
		$em->remove($personnel);
		$em->flush();
		
		return $this->redirect($this->generateUrl('sdis_admin_personnel_liste'));
	}
    /**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function modifierAction(Personnel $personnel) {

        $form = $this->createForm(new PersonnelType, $personnel);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
					$em->persist($personnel);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_personnel_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:Personnel:formulaire.html.twig', array('form' => $form->createView()));
    }
        
    /**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function nouveauAction() {
		$em = $this->getDoctrine()->getManager();
		$personnel = new Personnel;
        
        $form = $this->createForm(new PersonnelType, $personnel);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
					$em->persist($personnel);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_personnel_nouveau'));
				}
			}
        
        return $this->render('SdisAffichageBundle:Personnel:formulaire.html.twig', array('form' => $form->createView()));
    }
}
