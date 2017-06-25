<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Songs")
 * @ORM\Entity(repositoryClass="Application\Repository\SongsRepository")
 */
class Songs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Songs_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $songsId;

    /**
     * @var \Application\Entity\SongStatus
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\SongStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Song_Status_ID", referencedColumnName="Song_Status_ID")
     * })
     */
    private $songStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="Song_Name", type="string", length=50, nullable=true)
     */
    private $songName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Song_Artist", type="string", length=50, nullable=true)
     */
    private $songArtist;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="Record_Active", type="boolean", nullable=true)
     */
    private $recordActive;
    
    function getSongsId() {
        return $this->songsId;
    }

    function getSongStatus() {
        return $this->songStatus;
    }

    function getSongName() {
        return $this->songName;
    }

    function getSongArtist() {
        return $this->songArtist;
    }

    function getRecordActive() {
        return $this->recordActive;
    }

    function setSongStatus(\Application\Entity\SongStatus $songStatus) {
        $this->songStatus = $songStatus;
    }

    function setSongName($songName) {
        $this->songName = $songName;
    }

    function setSongArtist($songArtist) {
        $this->songArtist = $songArtist;
    }

    function setRecordActive($recordActive) {
        $this->recordActive = $recordActive;
    }


}
