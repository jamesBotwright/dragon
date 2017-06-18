<?php
/**
 * CalendarModelFactory
 * Configure and return instance of CalendarModel
 * @author James Botwright <jamesb@glazingvision.co.uk>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */

namespace Application\Model\Factory;

class CalendarModelFactory
{
    /**
     * @author James Botwright <jamesb@glazingvision.co.uk>
     * @version 09.04.17
     * 
     * @param $serviceLocator
     * @return \Application\Controller\CalendarModel
     */
    public function __invoke($serviceLocator)
    {
        $em              = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $calendarModel   = new \Application\Model\CalendarModel($em);
        return $calendarModel;
    }
}
