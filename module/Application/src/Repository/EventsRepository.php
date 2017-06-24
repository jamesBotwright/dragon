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
    public function getEvents()
    {
        try{
            $sql =
            "SELECT *
                FROM events AS events
                    
                ORDER BY events.start ASC
            ";
            
            //SELECT * FROM events WHERE start >= FROM_UNIXTIME(:start) AND end < FROM_UNIXTIME(:end) ORDER BY start ASC
            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (\Exception $e){
            echo 'Caught exception: ' . $e->getMessage() . ' - ' . __METHOD__;
        }
        return $results;
    }
}
