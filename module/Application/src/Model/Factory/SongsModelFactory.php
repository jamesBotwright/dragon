<?php
/**
 * SongsModelFactory
 * Configure and return instance of SongsModel
 * @author James Botwright <jamesb@glazingvision.co.uk>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */

namespace Application\Model\Factory;

class SongsModelFactory
{
    /**
     * @author James Botwright <jamesb@glazingvision.co.uk>
     * @version 09.04.17
     * 
     * @param $serviceLocator
     * @return \Application\Controller\SongsModel
     */
    public function __invoke($serviceLocator)
    {
        $em             = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $songsForm      = new \Application\Form\SongsForm($em);
        $songsEntity    = new \Application\Entity\Songs();
        $songsModel     = new \Application\Model\SongsModel(
            $em,
            $songsForm,
            $songsEntity
        );
        return $songsModel;
    }
}
