<?php

namespace Jsp\DynamiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kitpages\PDFBundle\lib\PDF;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function blockAction()
    {
		$moisFr = array('', 'Jan.', 'Fev.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Aout', 'Sept.', 'Oct.', 'Nov.', 'Dec.');
		
		$prochainEvenement = $this->getDoctrine()
				->getManager()
				->getRepository('JspDynamiqueBundle:Evenement')
				->prochainEvenement();
					
				
        return $this->render('JspDynamiqueBundle:Default:block.html.twig', array(
		'titre' => $prochainEvenement->getTitre(), 
		'description' => $prochainEvenement->getDescription(),
		'jour' => $prochainEvenement->getDate()->format('d'),
		'heureDebut' => $prochainEvenement->getDate()->format('H\hi'),
		'heureFin' => $prochainEvenement->getDateFin()->format('H\hi'),
		'mois' => $moisFr[$prochainEvenement->getDate()->format('m')]
		));
    }
	
	public function genererPDFAction($annee)
	{		
		$pdf = new PDF();
		
		$pdf->setSourceFile($this->get('kernel')->getRootDir() . "/../papierBase.pdf");
		$tpl = $pdf->importPage(1);
		$pdf->addPage();
		$pdf->useTemplate($tpl,0,0,0,0, true);
		$pdf->SetFont('Arial','BIU',18);
		$pdf->SetTextColor(91, 155, 213);
		$pdf->SetXY(65,30);
		$pdf->Write(0, 'Dates des exercices '.$annee);
		
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetY(60);
		$pdf->SetFillColor(160, 191, 220);
		$header = array('Exercice', 'Date', 'Horaire', 'Emplacement');
			// Largeurs des colonnes
		$w = array(65, 20, 40, 65);
		// En-tête
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],10,$header[$i],1,0,'C', true);
		$pdf->Ln();
		// Données
		$pdf->SetFont('Arial','',11);
		$pdf->SetFillColor(224,240,255);
		
		$evenements = $this->getDoctrine()
				->getManager()
				->getRepository('JspDynamiqueBundle:Evenement')
				->evenementsAnnuels($annee);
		$fill = false;
		foreach($evenements as $evenement)
		{
			$pdf->Cell($w[0],8,utf8_decode($evenement->getTitre()),1,0,'',$fill);
			$pdf->Cell($w[1],8,$evenement->getDate()->format('d\/m'),1,0,'',$fill);
			$pdf->Cell($w[2],8,$evenement->getDate()->format('H\hi').' -> '.$evenement->getDateFin()->format('H\hi'),1,0,'',$fill);
			$pdf->Cell($w[3],8,utf8_decode($evenement->getDescription()),1,1,'',$fill);
			$fill = !$fill;
		}
		// Trait de terminaison
		$pdf->Cell(array_sum($w),0,'','T');
		
		//La reponse
		$reponse = new Response;
		$reponse->headers->set('Content-Type', 'application/pdf');		
		$pdf->Output();
		return $reponse;
	}
	public function evenementsAction()
    {		
		$evenements = $this->getDoctrine()
				->getManager()
				->getRepository('JspDynamiqueBundle:Evenement')
				->evenementsAnnuels();
					
				
        return $this->render('JspDynamiqueBundle:Default:evenements.html.twig', array(
		'evenements' => $evenements,
		));
    }
	public function liensAction()
	{
		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('JspDynamiqueBundle:liens');
		
		$liste_liens = $repository->findAll();
        return $this->render('JspDynamiqueBundle:Default:liens.html.twig', array('liens' => $liste_liens));
	}
}
