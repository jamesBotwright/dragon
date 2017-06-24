<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class EventsRepository extends EntityRepository
{
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
                FROM events AS events
                    WHERE events.start >= FROM _UNIXTIME(:start)
                    AND events.end < FROM_UNIXTIME(:end)
                ORDER BY events.start ASC
            ";
            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->bindParam(':start', $startDate, \PDO::PARAM_INT);
            $stmt->bindParam(':end', $endDate, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (\Exception $e){
            echo "Caught exception: " . $e->getMessage() . "\n\n" . __METHOD__ 
                    . "\n\n Start Date = " . $startDate . ", End Date = " . $endDate;
        }
        return $results;
    }
}
