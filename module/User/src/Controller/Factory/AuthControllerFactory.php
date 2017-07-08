<?php
/**
 * AuthControllerFactory
 * Configure and return instance of UserController
 * @author James Botwright <jamesb@glazingvision.co.uk>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */

namespace Application\Controller\Factory;

class AuthControllerFactory
{
    /**
     * @author James Botwright <jamesb@glazingvision.co.uk>
     * @version 09.04.17
     * 
     * @param $container
     * @return \User\Controller\AuthController
     */
    public function __invoke($container)
    {
        $em                 = $container->get('doctrine.entitymanager.orm_default');
        $controller         = new \User\Controller\AuthController(
            $em
        );
        return $controller;
    }
}
