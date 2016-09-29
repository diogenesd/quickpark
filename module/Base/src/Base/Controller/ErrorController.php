<?php

namespace Base\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ErrorController extends AbstractController
{
    public function __construct() {
        
        
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function permissiondeniedAction()
    {
        return new ViewModel();
    }

    public function aditionalParameters(){
        return array();
    }
}
