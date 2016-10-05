<?php

namespace Admin\Form;

use Base\Form\AbstractForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Admin\Form\Filter\FuncionarioFilter;

/**
 * Description of FuncionarioForm
 *
 * @author mauricioschmitz
 */
class FuncionarioForm extends AbstractForm {

    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em) {

        $this->em = $em;

        parent::__construct(null);

        $this->setInputFilter(new FuncionarioFilter());

        $this->add(array(
            'name' => 'nome',
            'type' => 'text',
            'attributes' => array(
                'id' => 'nome',
                'required' => 'true',
                'class' => 'form-control',
                'autofocus' => 'false',
                'title' => 'Informe o nome',
            ),
            'options' => array(
                'label' => 'Nome',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                ),
            )
        ));

        $this->add(array(
            'name' => 'cpf',
            'type' => 'text',
            'attributes' => array(
                'id' => 'cpf',
                'required' => 'true',
                'class' => 'form-control',
                'autofocus' => 'false',
                'title' => 'Informe o CPF',
            ),
            'options' => array(
                'label' => 'CPF',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                ),
            )
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                'id' => 'email',
                'required' => 'true',
                'class' => 'form-control',
                'autofocus' => 'false',
                'title' => 'Por favor, insira seu e-mail'
            ),
            'options' => array(
                'label' => 'E-mail',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
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
                'autofocus' => 'false',
                'title' => 'Por favor, insira sua senha'
            ),
            'options' => array(
                'label' => 'Senha',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                ),
            )
        ));
    }

}
