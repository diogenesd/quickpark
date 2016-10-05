<?php

namespace Admin\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use NeuroSYS\DoctrineDatatables\TableBuilder;
use NeuroSYS\DoctrineDatatables\Renderer\TwigRenderer;

class FuncionarioController extends AbstractController {

    public function __construct() {
        $this->form = 'Admin\Form\FuncionarioForm';
        $this->controller = 'funcionario';
        $this->controllerUser = 'user';
        $this->service = 'Admin\Service\FuncionarioService';
        $this->entity = 'Admin\Entity\Funcionario';
        $this->entityUser = 'Login\Entity\User';
        $this->tituloTela = 'Funcionário';
    }

    public function indexAction() {
        $this->layout()->tituloTela = $this->tituloTela . ' | Lista';

        $this->getServiceLocator()->get('viewhelpermanager')->get('headScript')->appendFile($this->getRequest()->getBasePath() . '/min?g=datatables-js');

        return new ViewModel(array('route' => $this->route, 'controller' => $this->controller));
    }

    public function listAction() {
        $loader = new \Twig_Loader_String();
        $renderer = new TwigRenderer(new \Twig_Environment($loader));
        $params = $this->params()->fromQuery();

        $builder = new TableBuilder($this->getEm($this->entity), $params, null, $renderer);
        $builder
                ->from('Admin\Entity\Funcionario', 'f')
                ->join('f.user', 'u')
                ->add('number', 'f.id', null, array(
                    'template' => '<div class="dataTablesMore">+</div>'
                        )
                )
                ->add('text', 'u.nome')
                ->add('text', 'u.cpf')
                ->add('text', 'u.email')
                ->add("text", "u.active", null, array(
                    'template' => '{% if value %}<span class="label label-success" title="Ativo">Ativo</span>{% else %}<span class="label label-danger" title="Inativo">Inativo</span>{% endif %}'
                        )
                )
                ->add("text", "u.active", null, array(
                    'template' => '' .
                    '<div class="dropdown">
                    <button class="btn btn-icon btn-rounded btn-primary waves-effect dropdown-toggle" type="button" id="dropdownMenu{{values.id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>                   
                    <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu{{values.id}}">
                        <li><a href="' . $this->url()->fromRoute($this->route, array('controller' => $this->controller, 'action' => 'edit')) . '/{{values.id}}"> <i class="fa fa-pencil"></i> Editar</a></li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="' . $this->url()->fromRoute($this->route, array('controller' => $this->controller, 'action' => 'activeset')) . '/{{values.id}}/{% if value %}0{% else %}1{% endif %}"> <i class="fa fa-{% if value %}remove{% else %}check{% endif %}"></i> {% if value %}Desativar{% else %}Ativar{% endif %}</a>
                        </li>
                    </ul>
                  </div>'
                ))
                ->end()
        ;

        $response = $builder->getTable()
                ->getResponseArray() // hydrate entity, defaults to array
        ;

        $result = new JsonModel($response);
        return $result;
    }

    /**
     * Sobrescrita do método activeset
     */
    public function activesetAction() {
        $id = $this->params()->fromRoute('id', 0);
        $active = $this->params()->fromRoute('active');

        $em = $this->getEm();
        $qb = $em->createQueryBuilder();
        $qb->update($this->entityUser, 'e');
        $qb->set('e.active', ':active');
        $qb->setParameter('active', $active);
        $qb->where("e.id = :id");
        $qb->setParameter('id', $id);

        if ($active) {
            $acao = 'ativado';
        } else {
            $acao = 'desativado';
        }

        if ($qb->getQuery()->execute()) {
            $this->flashMessenger()->addSuccessMessage('Registro ' . $acao . ' com sucesso!');
        } else {
            $this->flashMessenger()->addErrorMessage('Não foi possivel alterar o registro');
        }
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }

//    public function validinsertAction() {
//        $em = $this->getEm();
//        $pessoa = $em->getRepository('Admin\Entity\Funcionario')->findBy(array('cpf' => $this->params()->fromPost('cpf', '')));
//        if (!empty($pessoa)) {
//            $this->flashMessenger()->addErrorMessage('CPF Já cadastrado!');
//            $request = $this->getRequest();
//            $request->getPost()->offsetUnset('cpf');
//        }
//        return $this->forward()
//                        ->dispatch('Admin\Controller\Funcionario', array('action' => 'insert'));
//    }
//
//    public function valideditAction() {
//        $em = $this->getEm();
//        $pessoas = $em->getRepository('Admin\Entity\Funcionario')->findBy(array('cpf' => $this->params()->fromPost('cpf')));
//
//        if (!empty($pessoas)) {
//            foreach ($pessoas as $pessoa) {
//                if ($pessoa->getId() != $this->params()->fromRoute('id')) {
//                    $this->flashMessenger()->addErrorMessage('CPF Já cadastrado!');
//                    $request = $this->getRequest();
//                    if ($this->params()->fromPost('cpf'))
//                        $request->getPost()->offsetUnset('cpf');
//                }
//            }
//        }
//        return $this->forward()
//                        ->dispatch('Admin\Controller\Funcionario', array('action' => 'edit', 'id' => $this->params()->fromRoute('id')));
//    }

    public function aditionalParameters() {
        $retorno = array();
        $id = $this->params()->fromRoute('id', 0);
        if ($id) {
            $em = $this->getEm();
            $funcionario = $em->getRepository('Admin\Entity\Funcionario')->findOneBy(array('id' => $id));
            $retorno['funcionario'] = $funcionario;
        }
        return $retorno;
    }

}
