<?php

namespace Sdis\ContactBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {

	/**
	* @Assert\Email( 
	*  message = "'{{ value }}' n'est pas un email valide",
	*  checkHost = true)
	*/
	protected $mail;
	
	/**
	* @Assert\NotBlank()
	*/
	protected $message;
    
    /**
    * @Assert\NotBlank()
    * @Assert\Choice(choices = {"commandant", "etat-major", "qm"}, message="Choisissez un destinataire valide.") 
    */
    protected $destinataire;

	public function getMail() {
		return $this->mail;
	}
	public function setMail($mail) {
		$this->mail = $mail;
	}
	
	public function getMessage() {
		return $this->message;
	}
	public function setMessage($message) {
		$this->message = $message;
	}
    
    public function setDestinataire($destinataire) {
        $this->destinataire = $destinataire;
    }
    public function getDestinataire() {
        return $this->destinataire;
    }
    public function getToMail() {
        switch($this->destinataire) {
            case 'commandant':
                return 'rose.fabrice@bluewin.ch';
            break;
            case 'qm':
                return 'sdis@aigle.ch';
            break;
            case 'etat-major':
                return array('rose.fabrice@bluewin.ch', 'geramo@hispeed.ch', 'taverney.marc@gmail.com', 'deregis.pascal@bluewin.ch');
            break;
        }
    }
}
?>
