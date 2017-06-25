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
        $em                 = $this->em;
        $songsRepository    = $em->getRepository('Application\Entity\Songs');
        $songs              = $songsRepository->getAllSuggestedSongs('Suggested');
        return $songs;
    }
    
    /**
     * 
     */
    public function getAllSetListSongs()
    {
        $em                 = $this->em;
        $songsRepository    = $em->getRepository('Application\Entity\Songs');
        $songs              = $songsRepository->getAllSuggestedSongs('Set List');
        return $songs;
    }
    
    /**
     * 
     */
    public function getAllReserveSongs()
    {
        $em                 = $this->em;
        $songsRepository    = $em->getRepository('Application\Entity\Songs');
        $songs              = $songsRepository->getAllSuggestedSongs('Reserved');
        return $songs;
    }
    
    /**
     * 
     */
    public function getAllRemovedSongs()
    {
        $em                 = $this->em;
        $songsRepository    = $em->getRepository('Application\Entity\Songs');
        $songs              = $songsRepository->getAllSuggestedSongs('Removed');
        return $songs;
    }
}
