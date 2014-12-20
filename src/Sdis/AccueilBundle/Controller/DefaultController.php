<?php

namespace Sdis\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SdisAccueilBundle:Default:index.html.twig');
    }
	public function organisationAction()
	{
		return $this->render('SdisAccueilBundle:Default:organisation.html.twig');
	}
	public function vehiculesAction()
	{
		return $this->render('SdisAccueilBundle:Default:vehicules.html.twig');
	}
}
