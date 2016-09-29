<?php

namespace Base\Form;

use Zend\Form\Form;
use Zend\Form\Element;
/**
 * Description of AbstractForm
 *
 * @author mauricioschmitz
 */
abstract class AbstractForm extends Form {

    public function __construct(){
        parent::__construct();
        
        $this->setAttribute('method', 'POST');
        
        $token = new Element\Csrf($this->getToken());
        $this->add($token);
    }
    
    public function getToken(){
        return 'token_'. get_class($this);
    }
}
