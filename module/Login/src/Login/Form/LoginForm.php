<?php

namespace Login\Form;

use Base\Form\AbstractForm;
use Login\Form\Filter\LoginFilter;

class LoginForm extends AbstractForm {

    public function __construct() {
        parent::__construct();

        $this->setInputFilter(new LoginFilter());
        $this->setAttributes(array(
            'id' => 'loginForm',
            'class', 'form-signin'
                )
        );
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                'id' => 'email',
                'required' => 'true',
                'class' => 'form-control',
                'title' => 'Por favor, insira seu e-mail',
                'autofocus' => 'true'
            ),
            'options' => array(
                'label' => 'E-mail',
                'label_attributes' => array(
                    'class' => 'control-label'
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
                'title' => 'Por favor, insira sua senha',
                'autofocus' => 'true'
            ),
            'options' => array(
                'label' => 'Senha',
                'label_attributes' => array(
                    'class' => 'control-label'
                ),
            )
        ));

        $this->add(array(
            'name' => 'entrar',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Entrar',
                'class' => 'btn btn-success btn-block'
            )
        ));
    }

}
