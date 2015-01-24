<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * PiquetsVss
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sdis\AffichageBundle\Entity\PiquetsVssRepository")
 */
class PiquetsVss
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
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

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
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=true)
     */
    private $chauffeur1;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Personnel")
     * @ORM\JoinColumn(nullable=true)
     */
    private $chauffeur2;


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
     * Set section
     *
     * @param Sdis\AffichageBundle\Entity\Sections $section
     * @return PiquetsVss
     */
    public function setSection(\Sdis\AffichageBundle\Entity\Sections $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return Sdis\AffichageBundle\Entity\Sections 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     * @return PiquetsVss
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
     * @return PiquetsVss
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
     * Set chauffeur1
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $chauffeur1
     * @return PiquetsVss
     */
    public function setChauffeur1(\Sdis\AffichageBundle\Entity\Personnel $chauffeur1)
    {
        $this->chauffeur1 = $chauffeur1;

        return $this;
    }

    /**
     * Get chauffeur1
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel 
     */
    public function getChauffeur1()
    {
        return $this->chauffeur1;
    }

    /**
     * Set chauffeur2
     *
     * @param \Sdis\AffichageBundle\Entity\Personnel $chauffeur2
     * @return PiquetsVss
     */
    public function setChauffeur2(\Sdis\AffichageBundle\Entity\Personnel $chauffeur2)
    {
        $this->chauffeur2 = $chauffeur2;

        return $this;
    }

    /**
     * Get chauffeur2
     *
     * @return \Sdis\AffichageBundle\Entity\Personnel
     */
    public function getChauffeur2()
    {
        return $this->chauffeur2;
    }
}
