<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class SongStatusRepository extends EntityRepository
{
   /**
     * @author James Botwright <james.botwright@glazingvision.co.uk>
     * @version v1.0 - 24.06.17
     * @throws Exception
     * @param string $status
     * @return array
     **/
    public function getSongStatusByStatus($status)
    {
        try{
            $qb = $this->_em->createQueryBuilder();
            $qb->select('songStatus')
                ->from('Application\Entity\SongStatus', 'songStatus')
                ->andWhere('songStatus.description = :status')
                ->setParameter('status', $status);
            $query = $qb->getQuery();
            $result = $query->getSingleResult();
        } catch (\Exception $e){
            echo '  Caught exception: ' . $e->getMessage() . ' - ' . __METHOD__
            . ' -  status = ' . $status;
        }
        return $result;
    }
}
