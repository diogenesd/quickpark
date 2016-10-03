<?php

namespace Ticket\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function __construct() {
        $this->form = 'Ticket\Form\Ticket';
        $this->controller = 'Ticket';
        $this->route = 'ticket/default';
        $this->service = 'Ticket\Service\TicketService';
        $this->entity = 'Ticket\Entity\Ticket';
        
        
    }
    public function indexAction()
    {
        $this->layout()->tituloTela = 'Dashboard';
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
