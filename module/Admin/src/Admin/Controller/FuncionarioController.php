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
        $this->route = 'admin/default';
        $this->service = 'Admin\Service\FuncionarioService';
        $this->entity = 'Admin\Entity\Funcionario';
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
//                ->add("text", "u.active", null, array(
//                    'template' => ''
//                    . '<div class="dropdown">
//                    <button class="btn btn-icon btn-rounded btn-primary waves-effect dropdown-toggle" type="button" id="dropdownMenu{{values.id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>                   
//                    <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu{{values.id}}">
//                        <li><a href="' . $this->url()->fromRoute($this->route, array('controller' => $this->controller, 'action' => 'edit')) . '/{{values.id}}"> <i class="fa fa-pencil"></i> Editar</a></li>
//                        <li role="separator" class="divider"></li>
//                        <li>
//                            <a href="' . $this->url()->fromRoute($this->route, array('controller' => $this->controller, 'action' => 'activeset')) . '/{{values.id}}/{% if value %}0{% else %}1{% endif %}"> <i class="fa fa-{% if value %}remove{% else %}check{% endif %}"></i> {% if value %}Desativar{% else %}Ativar{% endif %}</a>
//                        </li>
//                    </ul>
//                  </div>'
//                ))
                ->end()
        ;

        $response = $builder->getTable()
                ->getResponseArray() // hydrate entity, defaults to array
        ;
        
        $result = new JsonModel($response);
        return $result;
    }

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