<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class EventsForm extends Form implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('eventsForm');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Application\Entity\Events'))
                ->setObject(new \Application\Entity\Events);
        
        $this->add([
            'name' => 'id',
            'attributes' => [               
                'type'=> 'hidden',
            ],
        ]);
        
        $this->add([
            'name' => 'title',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'Title',
            ],
        ]);
        
        $this->add([
            'name' => 'description',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'Description',
            ],
        ]);
        
        $this->add([
            'name' => 'location',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'Location',
            ],
        ]);
        
        $this->add([
            'name' => 'contact',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'Contact',
            ],
        ]);
        
        $this->add([
            'name' => 'url',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'URL',
            ],
        ]);
        
        $this->add([
            'name' => 'start',
            'type' => 'Zend\Form\Element\DateTime',
            'attributes' => [
                'class' => 'datepicker form-control input-sm hasDatepicker',
            ],
            'options' => [
                'format'    => 'Y-m-d',
                'label'     => 'Start Date',
            ],
        ]);
        
        $this->add([
            'name' => 'end',
            'type' => 'Zend\Form\Element\DateTime',
            'attributes' => [
                'class' => 'datepicker form-control input-sm hasDatepicker',
            ],
            'options' => [
                'format'    => 'Y-m-d',
                'label'     => 'Start Date',
            ],
        ]);
    }
    
    public  function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required' => false,
            ],
            'title' => [
                'required' => true,
            ],
            'description' => [
                'required' => true,
            ],
            'location' => [
                'required' => false,
            ],
            'contact' => [
                'required' => false,
            ],
            'url' => [
                'required' => false,
            ],
            'start' => [
                'required' => true,
            ],
            'end' => [
                'required' => true,
            ],
        ];
    }
}
