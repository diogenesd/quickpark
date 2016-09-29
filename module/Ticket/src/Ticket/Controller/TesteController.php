<?php

namespace Ticket\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class TesteController extends AbstractController
{
    public function __construct() {
        $this->form = 'Ticket\Form\Teste';
        $this->controller = 'Ticket';
        $this->route = 'adm/default';
        $this->service = 'Ticket\Service\TesteService';
        $this->entity = 'Ticket\Entity\Teste';
        
        
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
