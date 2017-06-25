<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class EventsRepository extends EntityRepository
{
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
                ORDER BY events.start ASC
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
