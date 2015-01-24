<?php
// src/Sdis/DynamiqueBundle/Nouveautes.php

namespace Sdis\DynamiqueBundle;

use Sdis\DynamiqueBundle\Entity\Nouveautes as entite;

class Nouveautes {
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    public function ajouter($texte) {
        $nouveaute = new entite;
        $nouveaute->setDate(new \DateTime);
        $nouveaute->setDescription($texte);
        
        $this->em->persist($nouveaute);
        $this->em->flush();
    }
}