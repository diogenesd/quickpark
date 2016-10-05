<?php

namespace Login\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractController
{
    public function __construct() {
        $this->form = 'Login\Form\User';
        $this->controller = 'User';
        $this->route = 'admin/default';
        $this->service = 'Login\Service\UserService';
        $this->entity = 'Login\Entity\User';
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function insertAction()
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
