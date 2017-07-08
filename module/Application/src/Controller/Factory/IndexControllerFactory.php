<?php
/**
 * IndexControllerFactory
 * Configure and return instance of IndexController
 * @author James Botwright <jamesb@glazingvision.co.uk>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */

namespace Application\Controller\Factory;

class IndexControllerFactory
{
    /**
     * @author James Botwright <jamesb@glazingvision.co.uk>
     * @version 09.04.17
     * 
     * @param $container
     * @return \Application\Controller\IndexController
     */
    public function __invoke($container)
    {
        $applicationModel   = $container->get('ApplicationModel');
        $calendarModel      = $container->get('CalendarModel');
        $songsModel         = $container->get('SongsModel');
        $controller         = new \Application\Controller\IndexController(
            $applicationModel, 
            $calendarModel,
            $songsModel
        );
        return $controller;
    }
}
