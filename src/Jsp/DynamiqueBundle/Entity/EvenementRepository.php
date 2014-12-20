<?php
	namespace Jsp\DynamiqueBundle\Entity;
	
	use Doctrine\ORM\EntityRepository;
	
	class EvenementRepository extends EntityRepository
	{
		public function prochainEvenement() {
			$querybuilder = $this->_em->createQueryBuilder()
							->select('e')
							->from($this->_entityName, 'e')
							->where('e.dateFin >= :maintenant')
							->setParameter('maintenant', new \Datetime())
							->orderBy('e.dateFin')
							->setFirstResult(0)
							->setMaxResults(1);
			
			$query = $querybuilder->getQuery();
			$resultats = $query->getSingleResult();
			return $resultats;
		}
		public function evenementsAnnuels($annee = NULL) {
			if($annee == NULL) { $annee = date('Y'); }
			$querybuilder = $this->_em->createQueryBuilder()
							->select('e')
							->from($this->_entityName, 'e')
							->where('e.date BETWEEN :debut AND :fin')
							->setParameter('debut', new \Datetime($annee.'-01-01'))
							->setParameter('fin', new \Datetime($annee.'-12-31'))
							->orderBy('e.date');
			
			$query = $querybuilder->getQuery();
			$resultats = $query->getResult();
			return $resultats;
		}
		public function purgerEvenements() {
			$query = $this->_em->createQuery('DELETE FROM JspDynamiqueBundle:Evenement e WHERE e.date < :debut');
			$query->setParameter('debut', new \Datetime(date('Y').'-01-01'));
			$query->execute();
		}
	}
?>
