<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\Piquets;
use Sdis\AffichageBundle\Form\Type\PiquetsType;
use Sdis\AffichageBundle\Form\Type\PiquetsOfficiersType;

class PiquetsController extends Controller
{
    /**
    * @Secure(roles="ROLE_OFFICIER")
    */
    public function listeAction() {		
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:Piquets');
        $piquets = $repository->findby(array(), array('debut' => 'ASC'));    
            
        return $this->render('SdisAffichageBundle:Piquets:liste.html.twig', array('piquets' => $piquets));
    }
	/**
    * @Secure(roles="ROLE_ADMIN")
    */
	public function supprimerAction(Piquets $piquet) {
		return $this->render('SdisAffichageBundle:Piquets:supprimer.html.twig', array('piquet' => $piquet));
	}
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function supprimerOkAction(Piquets $piquet) {		
		$em = $this->getDoctrine()->getManager();
		$em->remove($piquet);
		$em->flush();
		
		return $this->redirect($this->generateUrl('sdis_admin_Piquets_liste'));
	}
    /**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function modifierAction(Piquets $piquet) {

        if($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(new PiquetsType, $piquet);            
        } else {
             $form = $this->createForm(new PiquetsOfficiersType, $piquet);
        }
        
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
					$em->persist($piquet);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_Piquets_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:Piquets:formulaire.html.twig', array('form' => $form->createView()));
    }
        
    /**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function nouveauAction() {
		$em = $this->getDoctrine()->getManager();
		$piquet = new Piquets;
        
        $form = $this->createForm(new PiquetsType, $piquet);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
					$em->persist($piquet);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_Piquets_nouveau'));
				}
			}
        
        return $this->render('SdisAffichageBundle:Piquets:formulaire.html.twig', array('form' => $form->createView()));
    }
}
