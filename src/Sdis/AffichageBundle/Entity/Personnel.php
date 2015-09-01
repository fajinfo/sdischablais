<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Personnel
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
     * @ORM\Column(name="grade", type="string", length=5)
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100)
     */
    private $prenom;

    /**
     * @var integer
     *
     * @ORM\Column(name="nip", type="integer")
     */
    private $nip;
    
    /**
    * @var boolean
    *
    * @ORM\Column(name="chauffeur", type="boolean")
    */
    private $chauffeur;
	
	/**
     *
     * @ORM\ManyToOne(targetEntity="Sdis\AffichageBundle\Entity\Sections")
     * @ORM\JoinColumn(nullable=true)
     */
    private $section;


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
     * Set grade
     *
     * @param string $grade
     * @return Personnel
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string 
     */
    public function getGrade()
    {
        return $this->grade;
    }
	
	/**
	* Get gradeTri
	*
	* @return integer
	*/
	public function getGradeTri()
	{
		$array = array('Recr' => '100', 'Sap' => '90', 'App' => '80', 'Cpl' => '70', 'Sgt' => '60', 'Sgtm' => '50', 'Adj' => '40', 'Lt' => '30', 'Plt' => '20', 'Cap' => '10', 'Maj' => '0');
		return $array[$this->grade];
	}

    /**
     * Set nom
     *
     * @param string $nom
     * @return Personnel
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
     * Set prenom
     *
     * @param string $prenom
     * @return Personnel
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nip
     *
     * @param integer $nip
     * @return Personnel
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return integer 
     */
    public function getNip()
    {
        return $this->nip;
    }
    
    /**
     * Set chauffeur
     *
     * @param boolean $chauffeur
     * @return Personnel
     */
    public function setchauffeur($chauffeur)
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    /**
     * Get chauffeur
     *
     * @return boolean
     */
    public function getchauffeur()
    {
        return $this->chauffeur;
    }
    
    public function __toString() {
        return $this->grade . ' ' . $this->nom . ' ' . $this->prenom;
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
}
