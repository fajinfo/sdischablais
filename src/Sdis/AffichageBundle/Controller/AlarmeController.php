<?php

namespace Sdis\AffichageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AlarmeController extends Controller
{
    public function sendAction($message) {
        
    }
    
    public function eventSourceAction() {
        $response = new Response("id: 1\nevent: alarme\ndata: INNONDATION, APPARTEMENT, VILLA, CHEMIN DES ERABLES 17,,.AIGLE INO_101 701F1(CI_J,J01)\n\n");
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }
}
