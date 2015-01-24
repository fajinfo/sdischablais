<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PiquetsRepository extends EntityRepository
{
    public function getNext() {
        $queryBuilder = $this->createQueryBuilder('p')
                        ->where('p.fin > :now')
                        ->orderBy('p.debut', 'ASC')
                        ->setFirstResult(0)
                        ->setMaxResults(6)
                        ->setParameter('now', new \DateTime())
                        ->getQuery();
        return $queryBuilder->getResult();
    }
    public function purger() {
			$query = $this->_em->createQuery('DELETE FROM SdisAffichageBundle:Piquets p WHERE p.fin < :now');
			$query->setParameter('now', new \Datetime(date('Y').'-01-01'));
			$query->execute();
		}
}
