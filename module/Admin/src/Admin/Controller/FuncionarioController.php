<?php

namespace Admin\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class FuncionarioController extends AbstractController
{
    public function __construct() {
        $this->form = 'Admin\Form\Funcionario';
        $this->controller = 'Admin';
        $this->route = 'admin/default';
        $this->service = 'Admin\Service\FuncionarioService';
        $this->entity = 'Admin\Entity\Funcionario';
        
        
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
