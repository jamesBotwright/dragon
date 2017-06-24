<?php
/**
 * Songs logic
 * @author James Botwright <jamesbotwright78@gmail.com>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */
namespace Application\Model;

class SongsModel
{
    /**
     * @var object 
     */
    private $em;
    
    /**
     * @param object $em
     */
    public function __construct(
        $em
    ) {
        $this->em           = $em;
    }
    
    /**
     * 
     */
    public function getAllSuggestedSongs()
    {
        return [];
    }
    
    /**
     * 
     */
    public function getAllSetListSongs()
    {
        return [];
    }
    
    /**
     * 
     */
    public function getAllReserveSongs()
    {
        return [];
    }
    
    /**
     * 
     */
    public function getAllRemovedSongs()
    {
        return [];
    }
}
