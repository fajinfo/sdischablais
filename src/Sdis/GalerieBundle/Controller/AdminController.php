<?php

namespace Sdis\GalerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdis\GalerieBundle\Form\Type\GaleriesType;
use Sdis\GalerieBundle\Entity\Galeries;
use Sdis\GalerieBundle\Entity\Photos;

class AdminController extends Controller
{
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function listeAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdisGalerieBundle:Galeries');
        $repository_photos = $em->getRepository('SdisGalerieBundle:Photos');
        if($slug != 'root') {
            $galerieParente = $repository->findOneBySlug($slug);
            if($galerieParente === null) {
                throw new HttpException(404, "La galerie demandée n'existe pas ;-)");
            }
            $galeries = $repository->findByParente($galerieParente);
            $filAriane = $galerieParente->getFilAriane();
            $titreGalParente = $galerieParente->getTitre();
            $slugGalParente = $galerieParente->getSlug();
            $photos = $repository_photos->findByGalerie($galerieParente);
        } else {
            $galeries = $repository->findByParente(null);
            $filAriane = array( 'root' => 'root');
            $titreGalParente = "root";
            $slugGalParente = "root";
            $photos = $repository_photos->findByGalerie(null);
        }
        return $this->render('SdisGalerieBundle:Admin:liste.html.twig', array('titreGalParente' => $titreGalParente, 'slugGalParente' => $slugGalParente, 'galeries' => $galeries, 'filAriane' => $filAriane, 'photos' => $photos));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function nouvelleGalerieAction()
    {
        $galeries = new Galeries;
        $form = $this->createForm(new GaleriesType, $galeries);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($galeries);
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_galerie_liste'));
            }
        }
        return $this->render('SdisGalerieBundle:Admin:nouvelleGalerie.html.twig', array( 'form' => $form->createView()));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function modifierGalerieAction(Galeries $galerie)
    {
        $form = $this->createForm(new GaleriesType, $galerie);
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $em= $this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirect($this->generateUrl('sdis_admin_galerie_liste'));
            }
        }
        return $this->render('SdisGalerieBundle:Admin:nouvelleGalerie.html.twig', array( 'form' => $form->createView()));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function supprimerGalerieAction(Galeries $galerie)
    {
        return $this->render('SdisGalerieBundle:Admin:supprimerGalerie.html.twig', array('galerie' => $galerie));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function supprimerGalerieOKAction(Galeries $galerie)
    {
        $em= $this->getDoctrine()->getManager();
        $repository_photos = $em->getRepository('SdisGalerieBundle:Photos');
        $photos = $repository_photos->findByGalerie($galerie);
        foreach($photos as $photo) {
            $em->remove($photo);
        }
        $em->remove($galerie);
        $em->flush();
        return $this->redirect($this->generateUrl('sdis_admin_galerie_liste'));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function nouvellePhotoAction($slug)
    {
        return $this->render('SdisGalerieBundle:Admin:nouvellePhoto.html.twig', array('galerie' => $slug));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function supprimerPhotoAction(Photos $photo)
    {
        return $this->render('SdisGalerieBundle:Admin:supprimerPhoto.html.twig', array('photo' => $photo));
    }
    /**
    * @Secure(roles="ROLE_PHOTOGRAPHE")
    */
    public function supprimerPhotoOKAction(Photos $photo)
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();
        return $this->redirect($this->generateUrl('sdis_admin_galerie_liste'));
    }
}
