<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\utilisationCaserne;
use Sdis\AffichageBundle\Form\Type\utilisationCaserneType;

class utilisationCaserneController extends Controller
{
    /**
    * @Secure(roles="ROLE_OFFICIER")
    */
    public function listeAction() {		
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:utilisationCaserne');
        $utilisations = $repository->findby(array(), array('debut' => 'ASC'));    
            
        return $this->render('SdisAffichageBundle:utilisationCaserne:liste.html.twig', array('utilisations' => $utilisations));
    }
	/**
    * @Secure(roles="ROLE_OFFICIER")
    */
	public function supprimerAction(utilisationCaserne $utilisation) {
		return $this->render('SdisAffichageBundle:utilisationCaserne:supprimer.html.twig', array('utilisation' => $utilisation));
	}
	/**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function supprimerOkAction(utilisationCaserne $utilisation) {		
		$em = $this->getDoctrine()->getManager();
		$em->remove($utilisation);
		$em->flush();
		
		return $this->redirect($this->generateUrl('sdis_admin_utilisationCaserne_liste'));
	}
    /**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function modifierAction(utilisationCaserne $utilisation) {

        $form = $this->createForm(new utilisationCaserneType, $utilisation);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
					$em->persist($utilisation);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_utilisationCaserne_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:utilisationCaserne:formulaire.html.twig', array('form' => $form->createView()));
    }
        
    /**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function nouveauAction() {
		$em = $this->getDoctrine()->getManager();
		$utilisation = new utilisationCaserne;
        
        $form = $this->createForm(new utilisationCaserneType, $utilisation);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
					$em->persist($utilisation);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_utilisationCaserne_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:utilisationCaserne:formulaire.html.twig', array('form' => $form->createView()));
    }
}
