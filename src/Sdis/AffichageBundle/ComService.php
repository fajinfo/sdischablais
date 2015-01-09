<?php
// src/Sdis/AffichageBundle/ComService.php

namespace Sdis\AffichageBundle;

class ComService {
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    public function purger() {
        $repository = $this->em->getRepository('SdisAffichageBundle:Communications');
		$repository->purger();
    }
}