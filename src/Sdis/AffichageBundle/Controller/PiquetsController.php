<?php

namespace Sdis\AffichageBundle\Controller;

use Sdis\AffichageBundle\Entity\GenerateParams;
use Sdis\AffichageBundle\Entity\PiquetsSpeciaux;
use Sdis\AffichageBundle\Form\Type\PiquetsSpeciauxType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\Piquets;
use Sdis\AffichageBundle\Form\Type\PiquetsType;
use Sdis\AffichageBundle\Form\Type\PiquetsTousType;
use Sdis\AffichageBundle\Form\Type\PiquetsOfficiersType;
use Sdis\AffichageBundle\Form\Type\PiquetsOfficiersTousType;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;
use Kitpages\PDFBundle\lib\PDF;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PiquetsController extends Controller
{
    /**
    * @Secure(roles="ROLE_OFFICIER")
    */
    public function listeAction() {	
		$this->get('sdis_affichage.comservice')->purger();	
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

        if($this->get('security.context')->isGranted('ROLE_QM')) {
            $form = $this->createForm(new PiquetsType, $piquet);            
        } else {
             $form = $this->createForm(new PiquetsOfficiersType, $piquet);
        }
        
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
                                
                if($request->request->get('sdis_tous')) {
                    if($this->get('security.context')->isGranted('ROLE_QM')) {
                        $form = $this->createForm(new PiquetsTousType, $piquet);            
                    } else {
                         $form = $this->createForm(new PiquetsOfficiersTousType, $piquet);
                    }
                }
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
	* @Secure(roles="ROLE_QM")
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
    public function pdfAction($annee, $format) {
		$this->get('sdis_affichage.comservice')->purger();
        $pdf = new PDF();

		$pdf->addPage('p', $format);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(60,7);
		if($annee != 0) {
			$pdf->Write(0, 'PLANNING DES TOURNUS DE PIQUETS '.$annee);
		} else {
			$pdf->Write(0, 'PLANNING DES TOURNUS DE PIQUETS '.date('Y'));
		}
        $pdf->Ln(7);
		
		if($format == 'A3') {
			$largeur = array(12,15,15,8,8,8,8,50,50,50,50);
			$deportX = 134;
		}
		else {
			$largeur = array(10,10,10,8,8,8,8,33,33,33,33);
			$deportX = 105;
		}
		
        $entetes = array("Date", '', '', 'Serv', 'Renf', 'Serv', 'Renf', 'Chef d\'intervention', 'Chef de groupe', 'Chauffeur', 'Intervenant');
        $mois = array('','janv', 'févr', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc');
        $jours = array('DI', 'LU', 'MA', 'ME', 'JE', 'VE', 'SA');
        
        //Têtes de colonnes
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(0,0,0);
        if($format == 'A3') 
			$pdf->SetFont('Arial','',10);
		else
			$pdf->SetFont('Arial','',8);
        for($i=0;$i<count($entetes);$i++) {
            $pdf->Cell($largeur[$i],7,$entetes[$i],1,0,'C',true);
        }
        $pdf->Ln();
        
        //Récuperer les piquets
        $piquets = $this->getDoctrine()
				->getManager()
				->getRepository('SdisAffichageBundle:Piquets')
				->findby(array(), array('debut' => 'ASC')); 
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0,0,0);
		if($format == 'A3') 
			$pdf->SetFont('Arial','',8);
		else
			$pdf->SetFont('Arial','',6);
		foreach($piquets as $piquet)
		{
			if($piquet->getCoachOfficier() != null OR $format=='A3') { $hauteur = 8; } else { $hauteur = 4; }
			
            $debut = $piquet->getDebut();
            $fin = $piquet->getFin();
			$pdf->Cell($largeur[0],$hauteur,utf8_decode($jours[$debut->format('w')]).'-'.utf8_decode($jours[$fin->format('w')]),1,0);
			$pdf->Cell($largeur[1],$hauteur,$debut->format('d').' '.utf8_decode($mois[$debut->format('n')]),1,0);
			$pdf->Cell($largeur[2],$hauteur,$fin->format('d').' '.utf8_decode($mois[$fin->format('n')]),1,0);
            $rgb = $this->hex2rgb($piquet->getSectionService()->getCouleur());
            $pdf->setFillColor($rgb[0], $rgb[1], $rgb[2]);
            $pdf->Cell($largeur[3],$hauteur,'',1,0,'', true);
            $rgb = $this->hex2rgb($piquet->getSectionRenfort()->getCouleur());
            $pdf->setFillColor($rgb[0], $rgb[1], $rgb[2]);
            $pdf->Cell($largeur[4],$hauteur,'',1,0, '', true);
            $pdf->Cell($largeur[5],$hauteur,$piquet->getSectionService(),1,0);
            $pdf->Cell($largeur[6],$hauteur,$piquet->getSectionRenfort(),1,0);
			if($piquet->getCoachOfficier() != null) {
				$pdf->Cell($largeur[7],4,utf8_decode($piquet->getChefIntervention()),'LTR',2);
				$pdf->Cell($largeur[7],4,utf8_decode($piquet->getCoachOfficier()),'LRB',0);
				$pdf->SetXY($deportX, ($pdf->GetY() - 4));
			} else {
				$pdf->Cell($largeur[7],$hauteur,utf8_decode($piquet->getChefIntervention()),1,0);
			}
            $pdf->Cell($largeur[8],$hauteur,utf8_decode($piquet->getChefGroupe()),1,0);
            $pdf->Cell($largeur[9],$hauteur,utf8_decode($piquet->getChauffeur()),1,0);
            $pdf->Cell($largeur[10],$hauteur,utf8_decode($piquet->getIntervenant()),1,0);
            $pdf->Ln();
		}
        
        $reponse = new Response;
		$reponse->headers->set('Content-Type', 'application/pdf');		
		$pdf->Output();
		return $reponse;
    }
    private function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       return $rgb; // returns an array with the rgb values
    }

    /**
     * @Secure(roles="ROLE_QM")
     */
    public function generatePiquetsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $generateParams = new GenerateParams();
        $generateParams->setFin(new \DateTime());
		$generateParams->setReset(true);
        $form = $this->createFormBuilder($generateParams)
            ->add('fin', 'date')
			->add('reset', 'checkbox', array('required' => false, 'label' => 'Remise à zéro du nombre de piquets par personne'))
            ->add('piquetsSpeciaux', 'collection', array('required' => 'false', 'type' => new PiquetsSpeciauxType(), 'allow_add' => true, 'allow_delete' => true))
            ->getForm();

        $request = $this->get('request');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $repoSections = $em->getRepository('SdisAffichageBundle:Sections');
            $repoPersonnel = $em->getRepository('SdisAffichageBundle:Personnel');
            $repoPiquets = $em->getRepository('SdisAffichageBundle:Piquets');

            $lastPiquet = $repoPiquets->getLast();

			if($generateParams->getReset()) {
				$repoPersonnel->resetNbPiquets();
			}

            $dateActuelle = $lastPiquet->getFin();
            $dateActuelle->add(new \DateInterval('P1W'));
            $dateFinGeneration = $generateParams->getFin();
            $ancienneSection = $lastPiquet->getSectionService()->getId();

            while($dateActuelle <= $dateFinGeneration) {
                $piquet = new Piquets();
                $dateDebut = new \DateTime();
                $dateDebut->setISODate($dateActuelle->format('Y'), $dateActuelle->format('W'), 6)->setTime(00, 00, 01);
                $piquet->setDebut($dateDebut);

                $dateFin = new \DateTime();
                $dateFin->setISODate($dateActuelle->format('Y'), $dateActuelle->format('W'), 7)->setTime(23, 59, 00);
                $piquet->setFin($dateFin);

                if ($ancienneSection == 1) {
                    $section = 6;
                } else {
                    $section = $ancienneSection - 1;
                }
                $sectionObjet = $repoSections->find($section);
                $piquet->setSectionService($sectionObjet);
                $piquet->setSectionRenfort($repoSections->find($ancienneSection));
                $ancienneSection = $section;

                $piquet->setChefIntervention($repoPersonnel->getPersonnelPiquet('off', $sectionObjet));
                $piquet->setChefGroupe($repoPersonnel->getPersonnelPiquet('sof', $sectionObjet, $piquet->getChefIntervention()));
                $piquet->setChauffeur($repoPersonnel->getPersonnelPiquet('chauffeur', $sectionObjet, $piquet->getChefIntervention(), $piquet->getChefGroupe()));
                $piquet->setIntervenant($repoPersonnel->getPersonnelPiquet('sap', $sectionObjet, $piquet->getChefIntervention(), $piquet->getChefGroupe(), $piquet->getChauffeur()));
                $em->persist($piquet);
                $dateActuelle->add(new \DateInterval('P1W'));

                foreach($generateParams->getPiquetsSpeciaux() as $piquetSpecial) {
                    $date = $piquetSpecial->getDebut();
                    $semainePiquet = $date->format('W');
                    if($dateActuelle->format('W') == $semainePiquet) {
						$piquet2 = new Piquets();
                        $piquet2->setDebut($piquetSpecial->getDebut());
                        $piquet2->setFin($piquetSpecial->getFin());
						$piquet2->setSectionService($piquet->getSectionService());
						$piquet2->setSectionRenfort($piquet->getSectionRenfort());
						$piquet2->setChefIntervention($piquet->getChefIntervention());
						$piquet2->setChefGroupe($piquet->getChefGroupe());
						$piquet2->setChauffeur($piquet->getChauffeur());
						$piquet2->setIntervenant($piquet->getIntervenant());
                        $em->persist($piquet2);
                    }
                }
            }
            $em->flush();
            return $this->redirect($this->generateUrl('sdis_admin_Piquets_liste'));
        }
        return $this->render('SdisAffichageBundle:Piquets:generer.html.twig', array('form' => $form->createView()));
    }
}
