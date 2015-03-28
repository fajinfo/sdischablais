<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class CalendrierController extends Controller
{
    private function topFromDate(\DateTime $date) {
        $heures = $date->format('G') * 60;
        $minutes = $date->format('i');
        //On Calcule le nombre de minutes depuis minuit
        $minutes += $heures;
        //On soustrait 9h (9x60 = 540)
        $minutes -= 540;
        //On multiplie par 0.935 soit le nombre de pixels par minutes
        return $minutes * 0.935;
    }
    private function bottomFromDate(\DateTime $date) {
        $heures = $date->format('G') * 60;
        $minutes = $date->format('i');
        //On Calcule le nombre de minutes depuis minuit
        $minutes += $heures;
        //On soustrait 21h30 (21.5x60 = 1290)
        $minutes -= 1290;
        //On multiplie par 0.935 soit le nombre de pixels par minutes
        $difference = $minutes * 0.935;
        return 700+$difference;
    }
    public function afficherAction() {	
        $repository = $this->getDoctrine()->getManager()->getRepository('SdisVehiculeBundle:Calendrier');
        $joursFr = array('', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
        $classJours = array('', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
        
        $headers = array();
        $events = array();
        $i = 0;
        
        while($i < 7) {
            $date = new \DateTime();
            $date->add(new \DateInterval('P'.$i.'D'));
            $dates[] = $date->format('Y-n-j');
            $headers[] = $joursFr[$date->format('N')].' '.$date->format('j/m');
            $nbEvenement = 0;
            
            $donnees = $repository->findForAffichage($date);
            $eventDay = array();
            
            foreach($donnees as $event) {
                $nbEvenement++;
            }
            
            if($nbEvenement == 2) {
                $left = array('0', '50');
                $right = array('50', '0');
            } else if($nbEvenement == 3) {
                $left = array('0', '33.3', '66.6');
                $right = array('66.6', '33.3', '0');
            } else if($nbEvenement == 4) {
                $left = array('0', '25', '50', '75');
                $right = array('75', '50', '25', '0');
            } else {
                $left = array('0');
                $right = array('0');
            }
            
            $i2 = 0;
            foreach($donnees as $evenement) {
                $eventFormate = array(
                    'vhc' => $evenement->getVhc()->getId(), 
                    'top' => $this->topFromDate($evenement->getDateDebut()), 
                    'bottom' => $this->bottomFromDate($evenement->getDateFin()), 
                    'startAt' => $evenement->getDateDebut()->format('H:i').' - '.$evenement->getDateFin()->format('H:i'), 
                    'title' => $evenement->getNomChauffeur(), 
                    'mission' => $evenement->getMission()->getImage(),
                    'remarque' => $evenement->getRemarque(),
                    'left' => $left[$i2],
                    'right' => $right[$i2]
                    );                
                $eventDay[] = $eventFormate;
                $i2++;
            }
            
            $events[] = $eventDay;
            $i++;
        }
        
        $heures = array( '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h');
        return $this->render('SdisAffichageBundle:Default:calendrier.html.twig', array('headers' => $headers, 'dates' => $dates, 'heures' => $heures, 'events' => $events));
    }
}
