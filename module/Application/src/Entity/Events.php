<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="Application\Repository\EventsRepository")
 */
class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=100, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=100, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100, nullable=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end = null;
    
    function getId()
    {
        return $this->id;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getLocation()
    {
        return $this->location;
    }

    function getContact() 
    {
        return $this->contact;
    }

    function getUrl()
    {
        return $this->url;
    }

    function getStart()
    {
        return $this->start;
    }

    function getEnd()
    {
        return $this->end;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    function setDescription($description)
    {
        $this->description = $description;
    }

    function setLocation($location)
    {
        $this->location = $location;
    }

    function setContact($contact)
    {
        $this->contact = $contact;
    }

    function setUrl($url)
    {
        $this->url = $url;
    }

    function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }
}
