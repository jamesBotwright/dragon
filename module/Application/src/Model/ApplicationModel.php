<?php
/**
 * App index logic
 * @author James Botwright <jamesbotwright78@gmail.com>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */
namespace Application\Model;

class ApplicationModel
{
    /**
     * @var object 
     */
    private $em;
    
    /**
     * @param object $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }
}
