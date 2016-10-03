<?php

namespace Admin\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController {

    public function __construct() {
        $this->form = 'Admin\Form\Admin';
        $this->controller = 'Admin';
        $this->route = 'admin/default';
        $this->service = 'Admin\Service\AdminService';
        $this->entity = 'Admin\Entity\Admin';
    }

    public function indexAction() {
        $this->layout()->tituloTela = 'Dashboard';
            $this->flashMessenger()->addErrorMessage("rola");
        return new ViewModel();
    }

    public function aditionalParameters() {
        return array();
    }

}
