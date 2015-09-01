<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\AffichageBundle\Entity\Piquets;
use Sdis\AffichageBundle\Form\Type\PiquetsType;
use Sdis\AffichageBundle\Form\Type\PiquetsTousType;
use Sdis\AffichageBundle\Form\Type\PiquetsOfficiersType;
use Sdis\AffichageBundle\Form\Type\PiquetsOfficiersTousType;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;
use Kitpages\PDFBundle\lib\PDF;
use Symfony\Component\HttpFoundation\Response;

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

        if($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(new PiquetsType, $piquet);            
        } else {
             $form = $this->createForm(new PiquetsOfficiersType, $piquet);
        }
        
		$request = $this->get('request');
			if($request->getMethod() == 'POST') {
                                
                if($request->request->get('sdis_tous')) {
                    if($this->get('security.context')->isGranted('ROLE_ADMIN')) {
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
    public function pdfAction() {
		$this->get('sdis_affichage.comservice')->purger();
        $pdf = new PDF();

		$pdf->addPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(60,7);
		$pdf->Write(0, 'PLANNING DES TOURNUS DE PIQUETS '.date('Y'));
        $pdf->Ln(7);
        $largeur = array(10,10,10,8,8,8,8,33,33,33,33);
        $entetes = array("Date", '', '', 'Serv', 'Renf', 'Serv', 'Renf', 'Chef d\'intervention', 'Chef de groupe', 'Chauffeur', 'Intervenant');
        $mois = array('','janv', 'févr', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc');
        $jours = array('DI', 'LU', 'MA', 'ME', 'JE', 'VE', 'SA');
        
        //Têtes de colonnes
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(0,0,0);
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
        $pdf->SetFont('Arial','',6);
		foreach($piquets as $piquet)
		{
            $debut = $piquet->getDebut();
            $fin = $piquet->getFin();
			$pdf->Cell($largeur[0],4,utf8_decode($jours[$debut->format('w')]).'-'.utf8_decode($jours[$fin->format('w')]),1,0);
			$pdf->Cell($largeur[1],4,$debut->format('d').' '.utf8_decode($mois[$debut->format('n')]),1,0);
			$pdf->Cell($largeur[2],4,$fin->format('d').' '.utf8_decode($mois[$fin->format('n')]),1,0);
            $rgb = $this->hex2rgb($piquet->getSectionService()->getCouleur());
            $pdf->setFillColor($rgb[0], $rgb[1], $rgb[2]);
            $pdf->Cell($largeur[3],4,'',1,0,'', true);
            $rgb = $this->hex2rgb($piquet->getSectionRenfort()->getCouleur());
            $pdf->setFillColor($rgb[0], $rgb[1], $rgb[2]);
            $pdf->Cell($largeur[4],4,'',1,0, '', true);
            $pdf->Cell($largeur[5],4,$piquet->getSectionService(),1,0);
            $pdf->Cell($largeur[6],4,$piquet->getSectionRenfort(),1,0);
            $pdf->Cell($largeur[7],4,utf8_decode($piquet->getChefIntervention()),1,0);
            $pdf->Cell($largeur[8],4,utf8_decode($piquet->getChefGroupe()),1,0);
            $pdf->Cell($largeur[9],4,utf8_decode($piquet->getChauffeur()),1,0);
            $pdf->Cell($largeur[10],4,utf8_decode($piquet->getIntervenant()),1,0);
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
}
