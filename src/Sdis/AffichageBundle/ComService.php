<?php
// src/Sdis/AffichageBundle/ComService.php

namespace Sdis\AffichageBundle;

class ComService {
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    public function purger() {
        $communications = $this->em->getRepository('SdisAffichageBundle:Communications');
		$communications->purger();
        
        $utilisation = $this->em->getRepository('SdisAffichageBundle:utilisationCaserne');
		$utilisation->purger();
        
        $piquetsvss = $this->em->getRepository('SdisAffichageBundle:PiquetsVss');
		$piquetsvss->purger();
        
        $piquets = $this->em->getRepository('SdisAffichageBundle:Piquets');
		$piquets->purger();
    }
}