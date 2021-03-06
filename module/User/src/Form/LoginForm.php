<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect user's login, password and 'Remember Me' flag.
 */
class LoginForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        parent::__construct('login-form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
        $this->add([            
            'type'      => 'text',
            'name'      => 'username',
            'options'   => [
                'label' => 'Your Username',
            ],
        ]);
        
        $this->add([            
            'type'      => 'password',
            'name'      => 'password',
            'options'   => [
                'label' => 'Password',
            ],
        ]);
        
        $this->add([            
            'type'  => 'checkbox',
            'name' => 'remember_me',
            'options' => [
                'label' => 'Remember me',
            ],
        ]);
        
        $this->add([            
            'type'  => 'hidden',
            'name' => 'redirect_url'
        ]);
        
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                'timeout' => 600
                ]
            ],
        ]);
        
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Sign in',
                'id' => 'submit',
            ],
        ]);
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
                
        $inputFilter->add([
            'name'     => 'username',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],                    
            ],                
        ]);     
        
        $inputFilter->add([
            'name'     => 'password',
            'required' => true,
            'filters'  => [                    
            ],                
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);     
        
        $inputFilter->add([
            'name'     => 'remember_me',
            'required' => false,
            'filters'  => [                    
            ],                
            'validators' => [
                [
                    'name'    => 'InArray',
                    'options' => [
                        'haystack' => [0, 1],
                    ]
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name'     => 'redirect_url',
            'required' => false,
            'filters'  => [
                ['name'=>'StringTrim']
            ],                
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 2048
                    ]
                ],
            ],
        ]);
    }        
}
