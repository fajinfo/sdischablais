<?php

namespace Sdis\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Calendrier
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sdis\VehiculeBundle\Entity\CalendrierRepository")
 * @Assert\Callback(methods={"intervaleValide"})
 */
class Calendrier
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
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Sdis\VehiculeBundle\Entity\TypeVehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vhc;

    /**
     * @var string
     *
     * @ORM\Column(name="typeUtilisation", type="string", length=255, nullable=true)
     */
    private $typeUtilisation;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min = "2", max = "255")
     * @var string
     *
     * @ORM\Column(name="nomChauffeur", type="string", length=255)
     */
    private $nomChauffeur;

    /**
     * @Assert\DateTime(message="Cette date doit respecter le format suivant : 01/02/2015 07h08")
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @Assert\DateTime(message="Cette date doit respecter le format suivant : 01/02/2015 07h08")
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;
    
    /**
    * @Assert\Length(min = "0", max = "255")
    * @var string
    *
    * @ORM\Column(name="remarque", type="string", length=255, nullable=true)
    */
    private $remarque;
    
    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Sdis\VehiculeBundle\Entity\Missions")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mission;



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
     * Set vhc
     *
     * @param Sdis\VehiculeBundle\Entity\TypeVehicules $vhc
     */
    public function setVhc(\Sdis\VehiculeBundle\Entity\TypeVehicules $vhc)
    {
        $this->vhc = $vhc;
    }

    /**
     * Get vhc
     *
     * @return Sdis\VehiculeBundle\Entity\TypeVehicules
     */
    public function getVhc()
    {
        return $this->vhc;
    }

    /**
     * Set typeUtilisation
     *
     * @param string $typeUtilisation
     * @return Calendrier
     */
    public function setTypeUtilisation($typeUtilisation)
    {
        $this->typeUtilisation = $typeUtilisation;

        return $this;
    }

    /**
     * Get typeUtilisation
     *
     * @return string 
     */
    public function getTypeUtilisation()
    {
        return $this->typeUtilisation;
    }

    /**
     * Set nomChauffeur
     *
     * @param string $nomChauffeur
     * @return Calendrier
     */
    public function setNomChauffeur($nomChauffeur)
    {
        $this->nomChauffeur = $nomChauffeur;

        return $this;
    }

    /**
     * Get nomChauffeur
     *
     * @return string 
     */
    public function getNomChauffeur()
    {
        return $this->nomChauffeur;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Calendrier
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Calendrier
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
    public function intervaleValide(ExecutionContextInterface $context) {
        if($this->dateDebut >= $this->dateFin) {
            $context->addViolationAt('dateFin', "La réservation ne peut pas durer moins d'une minute", array(), null);
        }
    }
    
    /**
     * Set remarque
     *
     * @param string $remarque
     * @return Calendrier
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string 
     */
    public function getRemarque()
    {
        return $this->remarque;
    }
    
    /**
     * Set mission
     *
     * @param Sdis\VehiculeBundle\Entity\Missions $mission
     */
    public function setMission(\Sdis\VehiculeBundle\Entity\Missions $mission)
    {
        $this->mission = $mission;
    }

    /**
     * Get mission
     *
     * @return Sdis\VehiculeBundle\Entity\Missions
     */
    public function getMission()
    {
        return $this->mission;
    }
}
