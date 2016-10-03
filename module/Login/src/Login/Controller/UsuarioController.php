<?php

namespace Login\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractController
{
    public function __construct() {
        $this->form = 'Login\Form\Usuario';
        $this->controller = 'Login';
        $this->route = 'admin/default';
        $this->service = 'Login\Service\UsuarioService';
        $this->entity = 'Login\Entity\Usuario';
        
        
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
