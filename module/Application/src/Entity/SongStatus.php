<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Song_Status")
 * @ORM\Entity(repositoryClass="Application\Repository\SongStatusRepository")
 */
class SongStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Song_Status_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $songStatusId;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=50, nullable=true)
     */
    private $description;
    
    function getSongStatusId() {
        return $this->songStatusId;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }
}
