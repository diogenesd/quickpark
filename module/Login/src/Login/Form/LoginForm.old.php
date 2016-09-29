<?php
namespace Login\Form;

use Base\Form\AbstractForm;
use Login\Form\Filter\LoginFilter;

class LoginForm extends AbstractForm
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setInputFilter(new LoginFilter());
        $this->setAttribute('class', 'form-signin');
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                'id' => 'email',
                'required' => 'true',
                'class' => 'form-control',
                'placeholder' => 'Email address',
                'autofocus' => 'true'
            ),
            'options' => array(
                'label' =>'E-mail',
                'label_attributes' => array(
                    'class'  => 'sr-only'
                ),
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                'id' => 'password',
                'required' => 'true',
                'class' => 'form-control',
                'placeholder' => 'Password',
                'autofocus' => 'true'
            ),
            'options' => array(
                'label' =>'Password',
                'label_attributes' => array(
                    'class'  => 'sr-only'
                ),
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'class' => 'btn btn-primary'
            )
        ));
    }
}