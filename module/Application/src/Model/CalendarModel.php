<?php
/**
 * Calendar logic
 * @author James Botwright <jamesbotwright78@gmail.com>
 * @copyright Copyright (c) 2017 Glazing Vision Ltd. (http://www.glazingvision.co.uk)
 */
namespace Application\Model;

class CalendarModel
{
    /**
     * @var object 
     */
    private $em;
    
    /**
     * @var object 
     */
    private $eventsEntity;
    
    /**
     * @var object 
     */
    private $eventsForm;
    
    /**
     * @param object $em
     */
    public function __construct(
        $em, 
        $eventsEntity, 
        $eventsForm
    ) {
        $this->em           = $em;
        $this->eventsEntity = $eventsEntity;
        $this->eventsForm   = $eventsForm;
    }
    
    /**
     * 
     */
    public function getEventsForm()
    {
        $eventsEntity   = $this->eventsEntity;
        $eventsForm     = $this->eventsForm;
        $eventsForm->bind($eventsEntity);
        return $eventsForm;
    }
    
    /**
     * 
     */
    public function getEvents()
    {
        $em = $this->em;
        $eventsRepo = $em->getRepository('Application\Entity\Events');
        $events     = $eventsRepo->getEvents();
        return $events;
    }
    
    /**
     * 
     */
    public function persistFlush()
    {
       $eventsEntity    = $this->eventsEntity;
       $em              = $this->em;
       $em->persist($eventsEntity);
       $em->flush();
    }
}
