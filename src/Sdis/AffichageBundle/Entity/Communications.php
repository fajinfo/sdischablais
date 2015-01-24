<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * Communications
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sdis\AffichageBundle\Entity\CommunicationsRepository")
 */
class Communications
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
     * @ORM\Column(name="dateDebut", type="datetime")
	 * @Assert\DateTime()
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
	 * @Assert\DateTime()
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
	 * @Assert\Length(min = "2", max = "28")
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="Jsp\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
	 * @Assert\Valid()
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
	 * @Assert\NotBlank()
     */
    private $contenu;


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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Communications
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
     * @return Communications
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

    /**
     * Set titre
     *
     * @param string $titre
     * @return Communications
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set user
     *
     * @param Jsp\UserBundle\Entity\User $user
     * @return Communications
     */
    public function setUser(\Jsp\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Jsp\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Communications
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }
}
