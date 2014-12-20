<?php

namespace Jsp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
	/**
	* @Secure(roles="ROLE_USER")
	*/
    public function indexAction()
    {
        return $this->render('JspAdminBundle::index.html.twig');
    }
}
