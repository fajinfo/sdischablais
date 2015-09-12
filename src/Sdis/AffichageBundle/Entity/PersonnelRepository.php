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
}
