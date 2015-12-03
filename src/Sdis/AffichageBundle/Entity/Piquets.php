<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * Piquets
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sdis\AffichageBundle\Entity\PiquetsRepository")
 */
class Piquets
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="datetime")
    * @Assert\DateTime()
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetime")
     * @Assert\DateTime()
     */
    private $fin;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sectionService;

   /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sectionRenfort;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chefIntervention;
	/**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coachOfficier;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chefGroupe;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chauffeur;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $intervenant;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     * @return Piquets
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Piquets
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set sectionService
     *
     * @param \Sdis\AffichageBundle\Entity\Sections $sectionService
     * @return Piquets
     */
    public function setSectionService(\Sdis\AffichageBundle\Entity\Sections $sectionService)
    {
        $this->sectionService = $sectionService;

        return $this;
    }

    /**
     * Get sectionService
     *
     * @return \Sdis\AffichageBundle\Entity\Sections
     */
    public function getSectionService()
    {
        return $this->sectionService;
    }

    /**
     * Set sectionRenfort
     *
     * @param \Sdis\AffichageBundle\Entity\Sections $sectionRenfort
     * @return Piquets
     */
    public function setSectionRenfort(\Sdis\AffichageBundle\Entity\Sections $sectionRenfort)
    {
        $this->sectionRenfort = $sectionRenfort;

        return $this;
    }

    /**
     * Get sectionRenfort
     *
     * @return \Sdis\AffichageBundle\Entity\Sections 
     */
    public function getSectionRenfort()
    {
        return $this->sectionRenfort;
    }

    /**
     * Set chefIntervention
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $chefIntervention
     * @return Piquets
     */
    public function setChefIntervention(\Sdis\AffichageBundle\Entity\Personnel $chefIntervention)
    {
        $this->chefIntervention = $chefIntervention;

        return $this;
    }

    /**
     * Get chefIntervention
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel 
     */
    public function getChefIntervention()
    {
        return $this->chefIntervention;
    }
	
	/**
     * Set coachOfficier
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $coachOfficier
     * @return Piquets
     */
    public function setCoachOfficier(\Sdis\AffichageBundle\Entity\Personnel $coachOfficier)
    {
        $this->coachOfficier = $coachOfficier;

        return $this;
    }

    /**
     * Get coachOfficier
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel 
     */
    public function getCoachOfficier()
    {
        return $this->coachOfficier;
    }

    /**
     * Set chefGroupe
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $chefGroupe
     * @return Piquets
     */
    public function setChefGroupe(\Sdis\AffichageBundle\Entity\Personnel $chefGroupe)
    {
        $this->chefGroupe = $chefGroupe;

        return $this;
    }

    /**
     * Get chefGroupe
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel
     */
    public function getChefGroupe()
    {
        return $this->chefGroupe;
    }

    /**
     * Set chauffeur
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $chauffeur
     * @return Piquets
     */
    public function setChauffeur(\Sdis\AffichageBundle\Entity\Personnel $chauffeur)
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    /**
     * Get chauffeur
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel
     */
    public function getChauffeur()
    {
        return $this->chauffeur;
    }

    /**
     * Set intervenant
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $intervenant
     * @return Piquets
     */
    public function setIntervenant(\Sdis\AffichageBundle\Entity\Personnel $intervenant)
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    /**
     * Get intervenant
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }
}
