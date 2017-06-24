<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class EventsRepository extends EntityRepository
{
    public function getEvents()
    {
        $events = [];
        return $events;
    }
}
