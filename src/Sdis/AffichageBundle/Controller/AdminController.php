<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\Communications;
use Sdis\AffichageBundle\Form\Type\CommunicationsRapideType;
use Sdis\AffichageBundle\Form\Type\CommunicationsType;

class AdminController extends Controller
{
    /**
    * @Secure(roles="ROLE_OFFICIER")
    */
    public function listeAction()
    {
        $this->get('sdis_affichage.comservice')->purger();
        
        $security = $this->get('security.context');
		
		$user = $security->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$communication = new Communications;
		$communication->setDateDebut(new \DateTime());
		$dateFin = new \DateTime;
		$dateFin->add(new \DateInterval('P3W'));
		$communication->setDateFin($dateFin);
		$communication->setUser($user);
		$form = $this->createForm(new CommunicationsRapideType, $communication);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
					$em->persist($communication);
					$em->flush();
					$communication->setTitre('');
					$communication->setContenu('');
				}
			}
        
        $repository = $em->getRepository('SdisAffichageBundle:Communications');
        if($security->isGranted('ROLE_QM')) {
            $listeCommunications = $repository->findAll();
        } else {
            $listeCommunications = $repository->findByUser($user);
        }       
            
        return $this->render('SdisAffichageBundle:Default:liste.html.twig', array('communications' => $listeCommunications, 'form' => $form->createView()));
    }
	/**
    * @Secure(roles="ROLE_OFFICIER")
    */
	public function supprimerAction(Communications $communication) {
		return $this->render('SdisAffichageBundle:Default:supprimer.html.twig', array('communication' => $communication));
	}
	/**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function supprimerOkAction(Communications $communication) {
		
		if(!$this->get('security.context')->isGranted('ROLE_QM')) {
			if($communication->getUser() != $this->get('security.context')->getToken()->getUser()) {
				throw $this->createAccessDeniedException('Vos droits d\'accès ne vous permettent pas de supprimer cette resource');
			}
		}
		
		$em = $this->getDoctrine()->getManager();
		$em->remove($communication);
		$em->flush();
		
		return $this->render('SdisAffichageBundle:Default:supprimerSuccess.html.twig');
	}
    /**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function modifierAction(Communications $communication) {
        if(!$this->get('security.context')->isGranted('ROLE_QM')) {
			if($communication->getUser() != $this->get('security.context')->getToken()->getUser()) {
				throw $this->createAccessDeniedException('Vos droits d\'accès ne vous permettent pas de modifier cette resource');
			}
		}
        
        $form = $this->createForm(new CommunicationsType, $communication);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
					$em->persist($communication);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_communications_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:Default:formulaire.html.twig', array('form' => $form->createView()));
    }
        
    /**
	* @Secure(roles="ROLE_OFFICIER")
	*/
	public function nouveauAction() {
        $security = $this->get('security.context');
		
		$user = $security->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$communication = new Communications;
		$communication->setDateDebut(new \DateTime());
		$dateFin = new \DateTime;
		$dateFin->add(new \DateInterval('P3W'));
		$communication->setDateFin($dateFin);
		$communication->setUser($user);
        
        $form = $this->createForm(new CommunicationsType, $communication);
		
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
				$form->bind($request);
				if($form->isValid()) {
					$em->persist($communication);
					$em->flush();
                    
                    return $this->redirect($this->generateUrl('sdis_admin_communications_liste'));
				}
			}
        
        return $this->render('SdisAffichageBundle:Default:formulaire.html.twig', array('form' => $form->createView()));
    }
}
