<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class EventsRepository extends EntityRepository
{
    public function getEvents()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('events')->from('Application\Entity\Events','events');
//        ->where('events.dayOfWeekId = :dayOfWeekId')
//        ->setParameter('dayOfWeekId', $dayOfWeekId);
        
        //SELECT * FROM events WHERE start >= FROM_UNIXTIME(:start) AND end < FROM_UNIXTIME(:end) ORDER BY start ASC
        
        try {
            $query      = $qb->getQuery();
            $events     = $query->getResult();
        } catch (\Exception $e) {
            echo 'Caught Exception: ' . $e->getMessage() . __METHOD__;
        }
        return $events;
    }
}
