<?php

namespace Admin\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ConfiguracaoController extends AbstractController
{
    public function __construct() {
        $this->form = 'Admin\Form\Configuracao';
        $this->controller = 'Configuracao';
        $this->route = 'admin/default';
        $this->service = 'Admin\Service\ConfiguracaoService';
        $this->entity = 'Admin\Entity\Configuracao';
        
        
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
