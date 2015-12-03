<?php
namespace Sdis\AffichageBundle\Entity;

class PiquetsSpeciaux {
    private $debut;
    private $fin;

    public function setDebut($debut) {
        $this->debut = $debut;
        return $this;
    }

    public function getDebut(){
        return $this->debut;
    }

    public function setFin($fin) {
        $this->fin = $fin;
        return $this;
    }
    public function getFin() {
        return $this;
    }
	public function format($format) {
		return $this->debut->format($format);
	}
};
?>