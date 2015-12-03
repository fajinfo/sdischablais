<?php

namespace Sdis\AffichageBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PersonnelRepository extends EntityRepository
{
    public function getFromSection($type, \Sdis\AffichageBundle\Entity\Sections $section)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.section = :section');
        switch ($type) {
            case 'off':
                $queryBuilder->andWhere("p.grade IN ('Lt', 'Plt', 'Cap', 'Maj')");
                break;
            case 'sof':
                $queryBuilder->andWhere("p.grade IN ('Adj', 'Sgtm', 'Sgt', 'Cpl')");
                break;
            case 'sap':
                $queryBuilder->andWhere("p.grade IN ('App', 'Sap', 'Recr')");
                break;
        };
        $queryBuilder->orderBy('p.nom')->setParameter('section', $section);
        return $queryBuilder->getQuery()->getResult();
    }

    public function resetNbPiquets() {
        $query = $this->_em->createQuery('UPDATE SdisAffichageBundle:Personnel p SET p.nbPiquets = 0');
        $query->execute();
    }
    public function getPersonnelPiquet($type, Sections $section, Personnel $int1 = null, Personnel $int2 = null, Personnel $int3 = null) {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.section = :section')
            ->setParameter('section', $section);
        switch ($type) {
            case 'off':
                $queryBuilder->andWhere("p.grade IN ('Lt', 'Plt', 'Cap', 'Maj')");
                break;
            case 'sof':
                $queryBuilder->andWhere("p.grade IN ('Adj', 'Sgtm', 'Sgt', 'Cpl')");
                break;
            case 'chauffeur':
                $queryBuilder->andWhere("p.chauffeur = true")->andWhere("p.grade IN ('Adj', 'Sgtm', 'Sgt', 'Cpl', 'App', 'Sap', 'Recr')");
                break;
            case 'sap':
                $queryBuilder->andWhere("p.chauffeur = false")->andWhere("p.grade IN ('App', 'Sap', 'Recr')");
                break;
        };

        if($int1 != null) {
            $queryBuilder->andWhere("p.id != :int1")->setParameter('int1', $int1->getId());
        }
        if($int2 != null) {
            $queryBuilder->andWhere("p.id != :int2")->setParameter('int2', $int2->getId());
        }
        if($int3 != null) {
            $queryBuilder->andWhere("p.id != :int3")->setParameter('int3', $int3->getId());
        }
        $queryBuilder->orderBy('p.nbPiquets')
            ->setFirstResult(0)
            ->setMaxResults(1);
        $intervenant = $queryBuilder->getQuery()->getSingleResult();
        $intervenant->addPiquets();
        $this->_em->flush($intervenant);
        return $intervenant;
    }
}
