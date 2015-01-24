<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\EntityRepository;

class utilisationCaserneRepository extends EntityRepository
{
    public function getNext() {
        $queryBuilder = $this->createQueryBuilder('u')
                        ->where('u.debut > :now')
                        ->orderBy('u.debut', 'ASC')
                        ->setFirstResult(0)
                        ->setMaxResults(4)
                        ->setParameter('now', new \DateTime())
                        ->getQuery();
        return $queryBuilder->getResult();
    }
    public function purger() {
			$query = $this->_em->createQuery('DELETE FROM SdisAffichageBundle:utilisationCaserne u WHERE u.fin < :now');
			$query->setParameter('now', new \Datetime(date('Y').'-01-01'));
			$query->execute();
		}
}
