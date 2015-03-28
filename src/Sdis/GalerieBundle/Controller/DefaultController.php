<?php

namespace Sdis\GalerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $rep_galeries = $em->getRepository('SdisGalerieBundle:Galeries');
        $rep_photos = $em->getRepository('SdisGalerieBundle:Photos');
        
        if($slug != 'root') {
            $galerieParente = $rep_galeries->findOneBySlug($slug);
            if($galerieParente === null) {
                throw new HttpException(404, "La galerie demandée n'existe pas ....");
            }
            $galeries = $rep_galeries->findByParente($galerieParente);
            $filAriane = $galerieParente->getFilAriane();
            $titreGalParente = $galerieParente->getTitre();
            $photos = $rep_photos->findByGalerie($galerieParente);
        } else {
            $galeries = $rep_galeries->findByParente(null);
            $filAriane = array( 'Galeries' => 'root');
            $titreGalParente = "root";
            $photos = $rep_photos->findByGalerie(null);
        }
        
        return $this->render('SdisGalerieBundle:Default:index.html.twig', array('titreGalParente' => $titreGalParente, 'galeries' => $galeries, 'filAriane' => $filAriane, 'photos' => $photos));
    }
}
