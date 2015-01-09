<?php

namespace Sdis\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVehicules
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TypeVehicules
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=8)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="textColor", type="string", length=8)
     */
    private $textColor;


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
     * Set nom
     *
     * @param string $nom
     * @return TypeVehicules
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return TypeVehicules
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set textColor
     *
     * @param string $textColor
     * @return TypeVehicules
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * Get textColor
     *
     * @return string 
     */
    public function getTextColor()
    {
        return $this->textColor;
    }
}
