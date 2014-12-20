<?php

namespace Jsp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Jsp\AdminBundle\Form\Type\GaleriesType;
use Jsp\GalerieBundle\Entity\Galeries;

class GalerieController extends Controller
{
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
    public function listeAction($parent)
    {
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspGalerieBundle:Galeries');
	    $repository_photos = $em->getRepository('JspGalerieBundle:Photos');
		
		if($parent != 'root') {
			$galerieParente = $repository->findOneByTitre($parent);
			if($galerieParente === null) {
				throw new HttpException(404, "Whoops! Looks like the post you are looking for dosen't exist. :/");
			}
			$galeries = $repository->findByParente($galerieParente);
			$filAriane = $galerieParente->getFilAriane();
			$titreGalParente = $galerieParente->getTitre();
			$photos = $repository_photos->findByGalerie($galerieParente);
		} else {
			$galeries = $repository->findByParente(null);
			$filAriane = array( 'Galeries' => 'root');
			$titreGalParente = "root";
			$photos = $repository_photos->findByGalerie(null);
		}
		
        return $this->render('JspAdminBundle:Galerie:liste.html.twig', array('titreGalParente' => $titreGalParente, 'galeries' => $galeries, 'filAriane' => $filAriane, 'photos' => $photos));
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
				
				return $this->redirect($this->generateUrl('jsp_admin_galerie_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:Galerie:nouvelleGalerie.html.twig', array( 'form' => $form->createView()));
	}
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
	public function modifierGalerieAction($id)
	{
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspGalerieBundle:Galeries');
		
		$galeries = $repository->find($id);
		
		$form = $this->createForm(new GaleriesType, $galeries);
		
		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$em->flush();
				
				return $this->redirect($this->generateUrl('jsp_admin_galerie_liste'));
			}
		}
		
		return $this->render('JspAdminBundle:Galerie:nouvelleGalerie.html.twig', array( 'form' => $form->createView()));
	}
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
	public function supprimerGalerieAction($id)
	{
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('JspGalerieBundle:Galeries');
		
		$galerie = $repository->find($id);
		
        return $this->render('JspAdminBundle:Galerie:supprimerGalerie.html.twig', array('galerie' => $galerie));
	}
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
	public function supprimerGalerieOKAction($id)
    {
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspGalerieBundle:Galeries');
		$repository_photos = $em->getRepository('JspGalerieBundle:Photos');
		
		$galerie = $repository->find($id);
		$photos = $repository_photos->findByGalerie($galerie);
		foreach($photos as $photo) {
			$em->remove($photo);
		}
		
		$em->remove($galerie);
		$em->flush();
		
        return $this->redirect($this->generateUrl('jsp_admin_galerie_liste'));
    }
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
	public function nouvellePhotoAction($parent)
	{		
		return $this->render('JspAdminBundle:Galerie:nouvellePhoto.html.twig', array('galerie' => $parent));
	}
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
	public function supprimerPhotoAction($id)
	{
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('JspGalerieBundle:Photos');
		
		$photo = $repository->find($id);
		
        return $this->render('JspAdminBundle:Galerie:supprimerPhoto.html.twig', array('photo' => $photo));
	}
	/**
	* @Secure(roles="ROLE_PHOTOGRAPHE")
	*/
	public function supprimerPhotoOKAction($id)
    {
		$em= $this->getDoctrine()->getManager();
		$repository = $em->getRepository('JspGalerieBundle:Photos');
		
		$photo = $repository->find($id);
		$em->remove($photo);
		$em->flush();
		
        return $this->redirect($this->generateUrl('jsp_admin_galerie_liste'));
    }
}
