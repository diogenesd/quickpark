<?php

namespace Admin\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class TesteController extends AbstractController
{
    public function __construct() {
        $this->form = 'Admin\Form\Teste';
        $this->controller = 'Admin';
        $this->route = 'adm/default';
        $this->service = 'Admin\Service\TesteService';
        $this->entity = 'Admin\Entity\Teste';
        
        
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
