<?php

namespace Sdis\DynamiqueBundle\Entity;

use Doctrine\ORM\EntityRepository;

class NouveautesRepository extends EntityRepository
{
    public function purger() {
        $query = $this->_em->createQuery('DELETE FROM SdisDynamiqueBundle:Nouveautes n ORDER BY n.date DESC LIMIT 100 OFFSET 10');
        $query->execute();
    }
}
?>
