<?php

namespace Sdis\GalerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Photos
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Photos
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
     * @ORM\Column(name="fichier", type="string", length=255)
     */
    private $fichier;

    /**
     * @ORM\ManyToOne(targetEntity="Sdis\GalerieBundle\Entity\Galeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $galerie;
    
    private $tempFilename;
    
    /**
    * @Assert\Image( minWidth = 200, minHeight = 200)
    */
    private $file;


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
     * Set fichier
     *
     * @param string $fichier
     * @return Photos
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string 
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Set galerie
     *
     * @param Sdis\GalerieBundle\Entity\Galeries $galerie
     * @return Photos
     */
    public function setGalerie(\Sdis\GalerieBundle\Entity\Galeries $galerie)
    {
        $this->galerie = $galerie;

        return $this;
    }

    /**
     * Get galerie
     *
     * @return Sdis\GalerieBundle\Entity\Galeries
     */
    public function getGalerie()
    {
        return $this->galerie;
    }
    
    public function setFile(File $file) {
        $this->file = $file;
        if(null !== $this->fichier) {
            $this->tempFilename = $this->fichier;
            $this->fichier = null;
        }
    }
    public function getFile() {
        return $this->file;
    }
    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload() {
        if(null === $this->file) {
            return;
        }
        $this->fichier = $this->file->guessExtension();
    }
    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload() {
        if(null === $this->file) {
            return;
        }
        if(null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id-'.'.$this->tempFilename;
            if(file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        $this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->fichier);
    }
    /**
    * @ORM\PreRemove()
    */
    public function preRemove() {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->fichier;
    }
    /**
    * @ORM\PostRemove()
    */
    public function remove() {
        if(file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }
    public function getUploadDir() {
        return 'uploads/img';
    }
    public function getUploadRootDir() {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    public function getWebPath() {
        return $this->getUploadDir().'/'.$this->id.'.'.$this->fichier;
    }
}
