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
     * @var object 
     */
    private $songsForm;
    
    /**
     * @var object 
     */
    private $songsEntity;
    
    /**
     * @param object $em
     */
    public function __construct(
        $em,
        $songsForm,
        $songsEntity
    ) {
        $this->em           = $em;
        $this->songsForm    = $songsForm;
        $this->songsEntity  = $songsEntity;
    }
    
    /**
     * 
     */
    public function getAddSongForm()
    {
        $songsForm      = $this->songsForm;
        $songsEntity    = $this->songsEntity;
        $songsForm->bind($songsEntity);
        $songsForm->get('songName')->setValue(null);
        $songsForm->get('songArtist')->setValue(null);
        $songsForm->get('songStatus')->setValue(1);
        $songsForm->get('recordActive')->setValue(true);
        return $songsForm;
    }
    
    /**
     * 
     */
    public function getSongsByStatus($status)
    {
        $em                 = $this->em;
        $songsRepository    = $em->getRepository(\Application\Entity\Songs::class);
        $songs              = $songsRepository->getSongsByStatus($status);
        return $songs;
    }
    
    /**
     * 
     */
    public function getSongById($songId)
    {
        $em                 = $this->em;
        $songsRepository    = $em->getRepository(\Application\Entity\Songs::class);
        $song               = $songsRepository->getSongById($songId);
        return $song;
    }
    
    /**
     * 
     */
    public function getSongStatusByStatus($status)
    {
        $em                     = $this->em;
        $songStatusRepository   = $em->getRepository(\Application\Entity\SongStatus::class);
        $status                 = $songStatusRepository->getSongStatusByStatus($status);
        return $status;
    }

    /**
     * 
     */
    public function setSongStatus($songId, $statusRequired = 'Removed')
    {
        $song   = $this->getSongById($songId);
        $status = $this->getSongStatusByStatus($statusRequired);
        $song->setSongStatus($status);
        $this->flushEM();
    }
    
    /**
     * 
     */
    public function persistFlush()
    {
       $songsEntity    = $this->songsEntity;
       $em             = $this->em;
       $em->persist($songsEntity);
       $this->flushEM();
    }
    
    public function flushEM()
    {
        $em = $this->em;
        $em->flush();
    }
}
