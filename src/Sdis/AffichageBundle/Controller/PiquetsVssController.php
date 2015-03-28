<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\PiquetsVss;
use Sdis\AffichageBundle\Form\Type\PiquetsVssType;
use Sdis\AffichageBundle\Form\Type\PiquetsVssOfficiersType;
use Doctrine\ORM\EntityRepository;

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
    public function remplacerAction(PiquetsVss $piquet) {
        $session = $this->get('session');
        
        if(!$session->has('nip')) {
             return $this->redirect($this->generateUrl('sdis_piquets'));
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:Personnel');
        
        $personnel = $repository->findOneByNip($session->get('nip'));
        
        if($piquet->getChauffeur1() == $personnel) {
            $formBuilder = $this->createFormBuilder($piquet)->add('chauffeur1', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                   return $er->createQueryBuilder('p')
                    ->where('p.chauffeur = 1')
                    ->orderBy('p.nom', 'ASC');
                },));
        } elseif($piquet->getChauffeur2() == $personnel) {
            $formBuilder = $this->createFormBuilder($piquet)->add('chauffeur2', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                    ->where('p.chauffeur = 1')
                    ->orderBy('p.nom', 'ASC');
                },));
        } else {
            throw $this->createAccessDeniedException('Vos droits d\'accès ne vous permettent pas de modifier cette resource');
        }
        
        $form = $formBuilder->getForm();
        
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em->persist($piquet);
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_piquets'));
            }
        }        
        return $this->render('SdisAffichageBundle:PiquetsVss:formulaireRemplacement.html.twig', array('form' => $form->createView()));
    }
}
