<?php

namespace Sdis\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\VehiculeBundle\Entity\Calendrier;
use Sdis\VehiculeBundle\Form\Type\CalendrierType;

class DefaultController extends Controller
{
    /**
    * @Secure(roles="ROLE_CHAUFFEUR")
    */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('SdisVehiculeBundle:TypeVehicules');
        $typesVehicules = $repository->findAll();
        
        return $this->render('SdisVehiculeBundle:Default:index.html.twig', array('typesVehicules' => $typesVehicules));
    }
    /**
    * @Secure(roles="ROLE_CHAUFFEUR")
    */
    public function donneesJsonAction(Request $request)
    {
        $dateDebut = new \DateTime($request->get('start'));
        $dateFin = new \DateTime($request->get('end'));
        
        $repository = $this->getDoctrine()->getManager()->getRepository('SdisVehiculeBundle:Calendrier');
        
        $listeEntrees = $repository->findForJson($dateDebut, $dateFin);
        $arrayReponse = array();
        
        foreach($listeEntrees as $evenement) {
            $arrayReponse[] = array(
                'id' => $evenement->getId(),
                'title' => $evenement->getNomChauffeur(),
                'allDay' => false,
                'start' => $evenement->getDateDebut()->format('c'),
                'end' => $evenement->getDateFin()->format('c'),
                'url' => '',
                'editable' => false,
                'color' => $evenement->getVhc()->getColor(),
                'textColor' => $evenement->getVhc()->getTextColor()
            );
        }
        $response = new Response(json_encode($arrayReponse));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    /**
    * @Secure(roles="ROLE_CHAUFFEUR")
    */
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisVehiculeBundle:Calendrier');
        $calendrier = $repository->find($id);
        $em->remove($calendrier);
        $em->flush();
        
        return $this->redirect($this->generateUrl('sdis_admin_vehicule'));
    }
    
    /**
    * @Secure(roles="ROLE_CHAUFFEUR")
    */
    public function nouveauAction($date)
    {
        $dateTime = new \DateTime($date);
        $calendrier = new Calendrier;
        $calendrier->setDateDebut($dateTime);
        $dateFin = new \DateTime($date);
        $dateFin->add(new \DateInterval("PT1H"));
        $calendrier->setDateFin($dateFin);
        $form = $this->createForm(new CalendrierType, $calendrier);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($calendrier);
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_vehicule'));
            }
        }
        return $this->render('SdisVehiculeBundle:Default:nouveau.html.twig', array( 'form' => $form->createView(), 'mod' => false));
    }
    /**
    * @Secure(roles="ROLE_CHAUFFEUR")
    */
    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisVehiculeBundle:Calendrier');
        $calendrier = $repository->find($id);
        $form = $this->createForm(new CalendrierType, $calendrier);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_vehicule'));
            }
        }
        return $this->render('SdisVehiculeBundle:Default:nouveau.html.twig', array( 'form' => $form->createView(), 'mod' => true, 'idReservation' => $id));
    }
}
