<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PiquetsVssRepository extends EntityRepository
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
			$query = $this->_em->createQuery('DELETE FROM SdisAffichageBundle:PiquetsVss p WHERE p.fin < :now');
			$query->setParameter('now', new \Datetime());
			$query->execute();
		}
     public function selectUser( \Sdis\AffichageBundle\Entity\Personnel $personnel) {
        $query = $this->_em->createQuery('SELECT p FROM SdisAffichageBundle:PiquetsVss p WHERE p.fin > :now AND ( p.chauffeur1 = :user OR p.chauffeur2 = :user )');
			$query->setParameter('now', new \Datetime());
            $query->setParameter('user', $personnel);
			return $query->getResult();
    }
}
