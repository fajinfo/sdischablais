<?php

namespace Sdis\GalerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Galeries
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Galeries
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50)
     * @Assert\Length(min=2, max=49)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50, nullable=true)
     * @Assert\Length(min=0, max=49)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Sdis\GalerieBundle\Entity\Galeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parente;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;


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
     * Set titre
     *
     * @param string $titre
     * @return Galeries
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
     * Set description
     *
     * @param string $description
     * @return Galeries
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set parente
     *
     * @param \Sdis\GalerieBundle\Entity\Galeries $parente
     * @return Galeries
     */
    public function setParente(\Sdis\GalerieBundle\Entity\Galeries $parente)
    {
        $this->parente = $parente;

        return $this;
    }

    /**
     * Get parente
     *
     * @return \Sdis\GalerieBundle\Entity\Galeries 
     */
    public function getParente()
    {
        return $this->parente;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Galeries
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getFilAriane() {
        if($this->parente === null) {
            return array('root' => 'root', $this->getSlug() => $this->getTitre());
        }
        return array_merge($this->getParente()->getFilAriane(), array($this->getSlug() => $this->getTitre()));
    }
}
