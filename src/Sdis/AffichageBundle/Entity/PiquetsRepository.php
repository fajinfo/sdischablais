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
			$query->setParameter('now', new \Datetime());
			$query->execute();
		}
    public function selectUser( \Sdis\AffichageBundle\Entity\Personnel $personnel) {
        $query = $this->_em->createQuery('SELECT p FROM SdisAffichageBundle:Piquets p WHERE p.fin > :now AND ( p.chefIntervention = :user OR p.chefGroupe = :user OR p.chauffeur = :user OR p.intervenant = :user )');
			$query->setParameter('now', new \Datetime());
            $query->setParameter('user', $personnel);
			return $query->getResult();
    }
    public function getLast() {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.fin', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery();
        return $queryBuilder->getSingleResult();
    }
}
