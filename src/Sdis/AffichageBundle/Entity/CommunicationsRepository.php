<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CommunicationsRepository extends EntityRepository
{
    public function getCommunicationsActuelles() {
        $queryBuilder = $this->createQueryBuilder('c')
                        ->where('c.dateDebut < :now')
                        ->andWhere('c.dateFin > :now')
                        ->setParameter('now', new \DateTime())
                        ->getQuery();
        return $queryBuilder->getResult();
    }
    public function purger() {
			$query = $this->_em->createQuery('DELETE FROM SdisAffichageBundle:Communications c WHERE c.dateFin < :now');
			$query->setParameter('now', new \Datetime);
			$query->execute();
		}
}
