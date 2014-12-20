<?php

namespace Sdis\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sdis\ContactBundle\Entity\Contact;

class DefaultController extends Controller
{
    public function contactAction()
    {
        $contact = new Contact();
		$formBuilder = $this->createFormBuilder($contact);
		$formBuilder
        ->add('destinataire', 'choice', array( 'choices' => array('commandant' => 'Commandant', 'etat-major' => 'État-major', 'qm' => 'Quartier-Maître'), 'expanded' => true, 'multiple' => false))
		->add('mail', 'email')
		->add('message', 'textarea');
		
		$form = $formBuilder->getForm();
		
		$request = $this->get('request');
		
		if($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if($form->isValid()) {
				$message = \Swift_Message::newInstance()
					->setSubject('Contact du site SDIS Chablais')
					->setFrom($contact->getMail())
					->setTo($contact->getToMail())
					->setBcc('fabian.joris@swiss-firefighters.ch')
					->setBody($this->renderView('SdisContactBundle:Contact:email.txt.twig', array('corps' => $contact->getMessage())));
				$this->get('mailer')->send($message);
			
				return $this->render('SdisContactBundle:Contact:succes.html.twig');
			}
		}
		
		return $this->render('SdisContactBundle:Contact:contact.html.twig', array( 'form' => $form->createView()));
    }
}
