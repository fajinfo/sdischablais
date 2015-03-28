<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\Piquets;
use Sdis\AffichageBundle\Form\Type\PiquetsType;
use Sdis\AffichageBundle\Form\Type\PiquetsOfficiersType;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;

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
    
    public function personnelAction() {
        $session = $this->get('session');
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:Personnel');
        
        if(!$session->has('nip')) {
            $request = $this->get('request');
            if($request->getMethod() == 'POST') {
                if($request->get('nip') != 0) {
                    $personnel = $repository->findOneByNip($request->get('nip'));
                    if($personnel->getNom() != '') {
                        $session->set('nip', $personnel->getNip());   
                        return $this->redirect($this->generateUrl('sdis_piquets'));
                    }
                }
            }
            return $this->render('SdisAffichageBundle:Piquets:connexion.html.twig');
        }
        
        $repPiquets = $em->getRepository('SdisAffichageBundle:Piquets');
        $repPiquetsVss = $em->getRepository('SdisAffichageBundle:PiquetsVss');
        
        $personnel = $repository->findOneByNip($session->get('nip'));
        $piquets = $repPiquets->selectUser($personnel);
        $piquetsVss = $repPiquetsVss->selectUser($personnel);
        
        return $this->render('SdisAffichageBundle:Piquets:afficherListe.html.twig', array('piquets' => $piquets, 'personnel' => $personnel, 'piquetsVss' => $piquetsVss));
    }
    
    public function logoutAction() {
        $session = $this->get('session');
        $session->remove('nip');
        return $this->redirect($this->generateUrl('sdis_accueil'));
    }
    
    public function remplacerAction(Piquets $piquet) {
        $session = $this->get('session');
        
        if(!$session->has('nip')) {
             return $this->redirect($this->generateUrl('sdis_piquets'));
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisAffichageBundle:Personnel');
        
        $personnel = $repository->findOneByNip($session->get('nip'));
        
        if($piquet->getChefIntervention() == $personnel) {
            $formBuilder = $this->createFormBuilder($piquet)->add('chefIntervention', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('p');
                    $qb->andWhere($qb->expr()->in('p.grade', ':grades'));
                    $qb ->orderBy('p.nom', 'ASC');
                    $qb->setParameter('grades', array('Maj', 'Cap', 'Plt', 'Lt'));
                    return $qb;
                },));
        } elseif($piquet->getChefGroupe() == $personnel) {
            $formBuilder = $this->createFormBuilder($piquet)->add('chefGroupe', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('p');
                    $qb->andWhere($qb->expr()->in('p.grade', ':grades'));
                    $qb ->orderBy('p.nom', 'ASC');
                    $qb->setParameter('grades', array('Adj', 'Sgtm', 'Sgt', 'Cpl'));
                    return $qb;
                },));
        } elseif($piquet->getChauffeur() == $personnel) {
            $formBuilder = $this->createFormBuilder($piquet)->add('chauffeur', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('p');
                    $qb->where('p.chauffeur = 1');
                    $qb->andWhere($qb->expr()->in('p.grade', ':grades'));
                    $qb ->orderBy('p.nom', 'ASC');
                    $qb->setParameter('grades', array('Adj', 'Sgtm', 'Sgt', 'Cpl', 'Sap', 'App'));
                    return $qb;
                },));
        } elseif($piquet->getIntervenant() == $personnel) {
            $formBuilder = $this->createFormBuilder($piquet)->add('intervenant', 'entity', array('class' => 'SdisAffichageBundle:Personnel', 'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('p');
                    $qb->andWhere($qb->expr()->in('p.grade', ':grades'));
                    $qb ->orderBy('p.nom', 'ASC');
                    $qb->setParameter('grades', array('Sap', 'App'));
                    return $qb;
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
        return $this->render('SdisAffichageBundle:Piquets:formulaireRemplacement.html.twig', array('form' => $form->createView()));
    }
}
