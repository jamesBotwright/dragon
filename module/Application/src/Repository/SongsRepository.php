<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class SongsRepository extends EntityRepository
{
    /**
     * @author James Botwright <james.botwright@glazingvision.co.uk>
     * @version v1.0 - 24.06.17
     * @throws Exception
     * @param int $songId
     * @return array
     **/
    public function getSongById($songId)
    {
        try{
            $qb = $this->_em->createQueryBuilder();
            $qb->select('songs')
                ->from('Application\Entity\Songs', 'songs')
                ->andWhere('songs.songsId = ?1')
                ->setParameter(1, $songId);
            $query = $qb->getQuery();
            $result = $query->getSingleResult();
        } catch (\Exception $e){
            echo '  Caught exception: ' . $e->getMessage() . ' - ' . __METHOD__
            . ' -  songId = ' . $songId;
        }
        return $result;
    }
    
    /**
     * @author James Botwright <james.botwright@glazingvision.co.uk>
     * @version v1.0 - 25.06.17
     * @throws Exception
     * @param string $status
     * @return []
     **/
    public function getSongsByStatus($status)
    {
        try{
            $sql =
            "SELECT *
                FROM Songs AS songs
                LEFT JOIN Song_Status AS songStatus ON
                    songStatus.Song_Status_ID = songs.Song_Status_ID
                    WHERE songStatus.Description = '" . $status . "'
                ORDER BY songs.Song_Name ASC
            ";
            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (\Exception $e){
            echo "Caught exception: " . $e->getMessage() . "\n\n" . __METHOD__
                / "\n\nStatus = " . $status;
        }
        return $results;
    }
}
