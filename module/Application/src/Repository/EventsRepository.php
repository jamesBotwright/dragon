<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class EventsRepository extends EntityRepository
{
    /**
     * @author James Botwright <james.botwright@glazingvision.co.uk>
     * @version v1.0 - 24.06.17
     * @throws Exception
     * @param int $eventId
     * @return array
     **/
    public function getEventById($eventId)
    {
        try{
            $qb = $this->_em->createQueryBuilder();
            $qb->select('events')
                ->from('Application\Entity\Events', 'events')
                ->andWhere('events.id = ?1')
                ->setParameter(1, $eventId);
            $query = $qb->getQuery();
            $result = $query->getSingleResult();
        } catch (\Exception $e){
            echo '  Caught exception: ' . $e->getMessage() . ' - ' . __METHOD__
            . ' -  eventId = ' . $eventId;
        }
        return $result;
    }
    
    /**
     * @author James Botwright <james.botwright@glazingvision.co.uk>
     * @version v1.0 - 24.06.17
     * @throws Exception
     * @param int $numberOfEvents
     * @return array
     **/
    public function getUpcomingEvents($numberOfEvents)
    {
        try{
            $sql =
            "SELECT *
                FROM Events AS events
                WHERE start >= CURDATE()                
                AND Record_Active = 1
                ORDER BY events.start ASC
                LIMIT " . $numberOfEvents . "
            ";
            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (\Exception $e){
            echo "Caught exception: " . $e->getMessage() . "\n\n" . __METHOD__ 
                    . "\n\n Number of events = " . $numberOfEvents;
        }
        return $results;
    }
    
    /**
     * @author James Botwright <james.botwright@glazingvision.co.uk>
     * @version v1.0 - 24.06.17
     * @throws Exception
     * @return array
     **/
    public function getEvents($startDate, $endDate)
    {
        try{
            $sql =
            "SELECT *
                FROM Events AS events
                    WHERE events.start >= :start
                    AND events.end < :end
                    AND Record_Active = 1
                ORDER BY events.start ASC
            ";
            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->bindParam(':start', $startDate);
            $stmt->bindParam(':end', $endDate);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (\Exception $e){
            echo "Caught exception: " . $e->getMessage() . "\n\n" . __METHOD__ 
                    . "\n\n Start Date = " . $startDate . ", End Date = " . $endDate . ",  ";
        }
        return $results;
    }
}
