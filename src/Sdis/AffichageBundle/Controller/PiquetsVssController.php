<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\PiquetsVss;
use Sdis\AffichageBundle\Form\Type\PiquetsVssType;
use Sdis\AffichageBundle\Form\Type\PiquetsVssOfficiersType;

class PiquetsVssController extends Controller
{
    /**
    * @Secure(roles="ROLE_OFFICIER")
    */
    public function listeAction() {		
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:PiquetsVss');
        $piquets = $repository->findby(array(), array('debut' => 'ASC'));    
            
        return $this->render('SdisAffichageBundle:PiquetsVss:liste.html.twig', array('piquets' => $piquets));
    }
	/**
    * @Secure(roles="ROLE_ADMIN")
    */
	public function supprimerAction(PiquetsVss $piquet) {
		return $this->render('SdisAffichageBundle:PiquetsVss:supprimer.html.twig', array('piquet' => $piquet));
	}
	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function supprimerOkAction(PiquetsVss $piquet) {		
		$em = $this->getDoctrine()->getManager();
		$em->remove($piquet);
		$em->flush();
		
		return $this->redirect($this->generateUrl('sdis_admin_PiquetsVss_liste'));
	}
    /**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function modifierAction(PiquetsVss $piquet) {

        if($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(new PiquetsVssType, $piquet);            
        } else {
             $form = $this->createForm(new PiquetsVssOfficiersType, $piquet);
        }
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
					$em->persist($piquet);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_PiquetsVss_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:PiquetsVss:formulaire.html.twig', array('form' => $form->createView()));
    }
        
    /**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function nouveauAction() {
		$em = $this->getDoctrine()->getManager();
		$piquet = new PiquetsVss;
        
        $form = $this->createForm(new PiquetsVssType, $piquet);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
					$em->persist($piquet);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_PiquetsVss_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:PiquetsVss:formulaire.html.twig', array('form' => $form->createView()));
    }
}
