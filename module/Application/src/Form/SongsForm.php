<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class SongsForm extends Form implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('songsForm');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Application\Entity\Songs'))
                ->setObject(new \Application\Entity\Songs);
        
        $this->add([
            'name' => 'songsId',
            'attributes' => [               
                'type'=> 'hidden',
            ],
        ]);
        
        $this->add([
            'name' => 'songStatus',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => [
                'class' => 'form-control input-sm ',
            ],
            'options' => [
                'object_manager' => $objectManager,
                'target_class' => 'Application\Entity\SongStatus',
                'allow_add' => true,
                'property' => 'description',
                'find_method' => [
                    'name' => 'findAll',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'songName',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'Song Name',
            ],
        ]);
        
        $this->add([
            'name' => 'songArtist',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'label' => 'Artist',
            ],
        ]);
        
        $this->add([
            'name'          => 'recordActive',
            'type'          => 'Zend\Form\Element\Checkbox',
            'attributes'    => [
                'class' => 'form-control input-sm',
            ],
            'options' => [
                'use_hidden_element'    => true,
                'checked_value'         => '1',
                'unchecked_value'       => '0',
                'label'                 => 'Record Active',
            ],
            
        ]);
    }
    
    public  function getInputFilterSpecification()
    {
        return [
            'songsId' => [
                'required' => false,
            ],
            'songStatus' => [
                'required' => true,
            ],
            'songName' => [
                'required' => true,
            ],
            'songArtist' => [
                'required' => true,
            ],
            'recordActive' => [
                'required' => true,
            ],
        ];
    }
}
