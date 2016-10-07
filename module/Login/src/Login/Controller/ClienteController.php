<?php

namespace Login\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ClienteController extends AbstractController
{
    public function __construct() {
        $this->form = 'Login\Form\ClienteForm';
        $this->controller = 'Cliente';
        $this->route = 'cadastro';
        $this->service = 'Login\Service\ClienteService';
        $this->entity = 'Login\Entity\Cliente';
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function recuperarsenhaAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
