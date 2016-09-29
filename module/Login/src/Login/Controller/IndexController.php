<?php

namespace Login\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Login\Utility\UserPassword;
use Zend\Session\Container;

class IndexController extends AbstractController {

    public function __construct() {
        $this->form = 'Login\Form\LoginForm';
        $this->controller = 'Login';
        $this->route = 'home';
        $this->service = 'Login\Service\LoginService';
        $this->entity = 'Login\Entity\Login';
    }

    public function indexAction() {
        $nlogado = $this->params()->fromRoute('nlogado', 0);
        if (is_string($this->form))
            $form = new $this->form();
        else
            $form = $this->form;

        $request = $this->getRequest();
        $errors = null;
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                $userPassword = new UserPassword();
                $encyptPass = $userPassword->create($data['password']);


                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['email']);
                $adapter->setCredentialValue($encyptPass);
                $authResult = $authService->authenticate();
                if ($authResult->isValid()) {
                    $this->flashMessenger()->addSuccessMessage('Logado com successo');
                    return $this->redirect()->toRoute('adm');
                } else {
                    $this->flashMessenger()->addErrorMessage('Credenciais inválidas');
                    $this->redirect()->toRoute($this->route);
                }
                $this->redirect()->toRoute($this->route);
                // Logic for login authentication
            } else {
                $errors = $form->getMessages();
                foreach ($errors as $key => $messages) {
                    $message = '';
                    if (!is_numeric($key))
                        $message .= '<b>' . $key . '</b>: ';

                    foreach ($messages as $message) {
                        $message .= $message . '<br>';
                    }
                    if ($message != '') {
                        $this->flashMessenger()->addErrorMessage($message);
                    }
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function logoutAction() {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        $session = new Container('User');
        $session->getManager()->destroy();

        $authService->clearIdentity();

        $this->flashMessenger()->addSuccessMessage('Logout realizado com successo');

        $this->redirect()->toRoute($this->route);
    }

    private function _getUserDetails($email) {
        $em = $this->getEm();
        return $em->getRepository('Login\Entity\User')->findBy(array('email' => $email));
    }

    public function aditionalParameters() {
        return array();
    }

}
