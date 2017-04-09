<?php
/**
 * ApplicationModelFactory
 * Configure and return instance of ApplicationModel
 * @author James Botwright <jamesb@glazingvision.co.uk>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */

namespace Application\Model\Factory;

class ApplicationModelFactory
{
    /**
     * @author James Botwright <jamesb@glazingvision.co.uk>
     * @version 09.04.17
     * 
     * @param $serviceLocator
     * @return \Application\Controller\ApplicationModel
     */
    public function __invoke($serviceLocator)
    {
        $em                 = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $applicationModel   = new \Application\Model\ApplicationModel($em);
        return $applicationModel;
    }
}
