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
        $applicationModel   = $container->get(ApplicationModel::class);
        $calendarModel      = $container->get(CalendarModel::class);
        $songsModel         = $container->get(SongsModel::class);
        $controller         = new \Application\Controller\IndexController(
            $applicationModel, 
            $calendarModel,
            $songsModel
        );
        return $controller;
    }
}
