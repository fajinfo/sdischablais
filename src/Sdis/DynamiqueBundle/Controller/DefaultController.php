<?php

namespace Sdis\DynamiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function nouveautesAction()
    {
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('SdisDynamiqueBundle:Nouveautes');
        $nouveautes = $repository->findBy(array(), array('date'=> 'desc'), 10, 0); 
        return $this->render('SdisDynamiqueBundle:Default:nouveautes.html.twig', array('nouveautes' => $nouveautes));
    }
}
