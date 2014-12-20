<?php

namespace Jsp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JspUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
