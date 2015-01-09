<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($token, $dia)
    {
        if($token != '2') {
            throw new \InvalidArgumentException('Le jeton n\'est pas valide');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $listeEvenements = $em->createQueryBuilder()
                        ->select('e')
                        ->from('JspDynamiqueBundle:Evenement', 'e')
                        ->where('e.date > :date')
                        ->orderBy('e.date', 'ASC')
                        ->setParameter('date', new \DateTime())
                        ->setFirstResult(0)
                        ->setMaxResults(4)
                        ->getQuery()
                        ->getResult();
        $listeCommunications = $em->getRepository('SdisAffichageBundle:Communications')->getCommunicationsActuelles();
            
        return $this->render('SdisAffichageBundle:Default:index.html.twig', array('evenements' => $listeEvenements, 'communications' => $listeCommunications, 'token' => $token, 'dia' => $dia));
    }
}
