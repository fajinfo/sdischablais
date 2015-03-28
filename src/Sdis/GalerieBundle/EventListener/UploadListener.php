<?php
namespace Sdis\GalerieBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sdis\GalerieBundle\Entity\Photos;

class UploadListener {
    private $doctrine;
    private $validator;
    public function __construct($doctrine, $validator)
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }
    public function onUpload(PostPersistEvent $event) {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository('SdisGalerieBundle:Galeries');
        $request = $event->getRequest();
        $galerie = $request->headers->get('galerie');
        if($galerie == "root") {
            $parente = null;
        } else {
            $parente = $repository->findOneBySlug($galerie);
            if($parente === null) {
                throw new HttpException(406, '{"error": "La galerie parente n\'existe pas"}');
            }
        }
        $photos = new Photos;
        $photos->setFile($event->getFile());
        $photos->setGalerie($parente);
        $erreurs = $this->validator->validate($photos);
        if(count($erreurs) == 0) {
            $em->persist($photos);
            $em->flush();
        }
        else {
            throw new HttpException(406, '{"error": "Le fichier n\'est pas valide"}');
        }
    }
}