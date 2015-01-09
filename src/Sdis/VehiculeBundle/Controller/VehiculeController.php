<?php

namespace Sdis\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\VehiculeBundle\Entity\TypeVehicules;
use Sdis\VehiculeBundle\Form\Type\TypeVehiculesType;

class VehiculeController extends Controller
{
    /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function listeAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('SdisVehiculeBundle:TypeVehicules');
        $typesVehicules = $repository->findAll();
        
        return $this->render('SdisVehiculeBundle:Vehicule:liste.html.twig', array('typesVehicules' => $typesVehicules));
    }
    /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisVehiculeBundle:TypeVehicules');
        $vhc = $repository->find($id);
        $em->remove($vhc);
        $em->flush();
        
        return $this->redirect($this->generateUrl('sdis_admin_vehicule_vhcliste'));
    }
    
    /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function nouveauAction()
    {
        $vhc = new TypeVehicules;
        $form = $this->createForm(new TypeVehiculesType, $vhc);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($vhc);
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_vehicule_vhcliste'));
            }
        }
        return $this->render('SdisVehiculeBundle:Vehicule:nouveau.html.twig', array( 'form' => $form->createView()));
    }
    /**
    * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisVehiculeBundle:TypeVehicules');
        $vhc = $repository->find($id);
        $form = $this->createForm(new TypeVehiculesType, $vhc);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_vehicule_vhcliste'));
            }
        }
        return $this->render('SdisVehiculeBundle:Vehicule:nouveau.html.twig', array( 'form' => $form->createView()));
    }
}