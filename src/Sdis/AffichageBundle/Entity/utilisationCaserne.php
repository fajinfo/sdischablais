<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * utilisationCaserne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sdis\AffichageBundle\Entity\utilisationCaserneRepository")
 */
class utilisationCaserne
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
     * @var string
     *
     * @ORM\Column(name="motif", type="string", length=255)
     * @Assert\Length(min = "2", max = "255")
     */
    private $motif;

    /**
     * @var string
     *
     * @ORM\Column(name="requerant", type="string", length=100)
     * @Assert\Length(min = "2", max = "100")
     */
    private $requerant;


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
     * @return utilisationCaserne
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
     * @return utilisationCaserne
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
     * Set motif
     *
     * @param string $motif
     * @return utilisationCaserne
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string 
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set requerant
     *
     * @param string $requerant
     * @return utilisationCaserne
     */
    public function setRequerant($requerant)
    {
        $this->requerant = $requerant;

        return $this;
    }

    /**
     * Get requerant
     *
     * @return string 
     */
    public function getRequerant()
    {
        return $this->requerant;
    }
}
