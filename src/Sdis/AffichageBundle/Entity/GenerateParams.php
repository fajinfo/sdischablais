<?php

namespace Sdis\AffichageBundle\Entity;

class GenerateParams {
    private $fin;
    private $piquetsSpeciaux;
	private $reset;

    public function __construct() {
        $this->piquetsSpeciaux = array();
    }
    public function setFin(\DateTime $fin) {
        $this->fin = $fin;
    }
    public function getFin() {
        return $this->fin;
    }
	
	public function setReset($reset) {
		$this->reset = $reset;
	}
	public function getReset() {
		return $this->reset;
	}

    public function getPiquetsSpeciaux() {
        return $this->piquetsSpeciaux;
    }
    public function addPiquetsSpeciaux(PiquetsSpeciaux $piquetsSpeciaux) {
        $this->piquetsSpeciaux[] = $piquetsSpeciaux;
    }
    public function removePiquetsSpeciaux(PiquetsSpeciaux $piquetsSpeciaux) {
        $this->piquetsSpeciaux->removeElement($piquetsSpeciaux);
    }
}