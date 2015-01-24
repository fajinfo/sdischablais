<?php

namespace Sdis\DynamiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\DynamiqueBundle\Entity\Nouveautes;
use Sdis\DynamiqueBundle\Form\Type\NouveautesType;

class AdminController extends Controller
{
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function listeNouveautesAction()
    {
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('SdisDynamiqueBundle:Nouveautes');
        $nouveautes = $repository->findBy(array(), array('date'=> 'desc')); 
        return $this->render('SdisDynamiqueBundle:Admin:liste.html.twig', array('nouveautes' => $nouveautes));
    }
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function ajoutNouveautesAction()
    {
        $nouveaute = new Nouveautes;
        $nouveaute->setDate(new \DateTime());
        $form = $this->createForm(new NouveautesType, $nouveaute);
        
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($nouveaute);
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_nouveautes'));
            }
        }
        return $this->render('SdisDynamiqueBundle:Admin:nouveau.html.twig', array( 'form' => $form->createView()));
    }
    /**
    * @Secure(roles="ROLE_ADMIN")
    */  
    public function supprimerNouveautesAction($id)
    {
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('SdisDynamiqueBundle:Nouveautes');
        $nouveaute = $repository->find($id);
        return $this->render('SdisDynamiqueBundle:Admin:supprimer.html.twig', array('nouveaute' => $nouveaute));
    }
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function supprimerokNouveautesAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisDynamiqueBundle:Nouveautes');
        $evenement = $repository->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->render('SdisDynamiqueBundle:Admin:supprimerSucces.html.twig');
    }
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function modifierNouveautesAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisDynamiqueBundle:Nouveautes');
        $nouveaute = $repository->find($id);
        $form = $this->createForm(new NouveautesType, $nouveaute);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_nouveautes'));
            }
        }
        return $this->render('SdisDynamiqueBundle:Admin:nouveau.html.twig', array( 'form' => $form->createView()));
    }
}
