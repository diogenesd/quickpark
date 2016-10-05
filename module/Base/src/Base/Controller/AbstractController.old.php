<?php

namespace Base\Controller;

/**
 * Description of AbstractController
 *
 * @author rodrigoheinzle
 */
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController {

    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    protected $data_elements = array();
    protected $external_objects = array();
    protected $tituloTela;
    protected $scripts_styles = array();

    /**
     * Abstract method
     */
    abstract public function __construct();

    abstract public function aditionalParameters();

    /**
     * 1 - Listar registros
     */
    public function indexAction() {
        $list = $this->getEm()->getRepository($this->entity)->findAll();

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage(10);

        return new ViewModel(array('data' => $paginator, 'page' => $page));
    }

    /**
     * 2 - Inserir registro
     */
    public function insertAction() {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $this->layout()->tituloTela = $this->tituloTela . ' | Adicionar';

        if (is_string($this->form))
            $form = new $this->form($dbAdapter);
        else
            $form = $this->form($dbAdapter);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->service);
                $data = $request->getPost()->toArray();
                foreach ($data as $key => $valor) {
                    if (in_array($key, $this->data_elements)) {
                        $dataHora = explode(' ', $valor);
                        $data[$key] = new \DateTime(implode('-', array_reverse(explode('/', $dataHora[0]))) . ' ' . (isset($dataHora[1]) ? $dataHora[1] : ''));
                    }
                }

                foreach ($this->external_objects as $campo => $entity) {

                    $busca = $this->getEm()->getRepository($entity)->find($data[$campo]);
                    $data[$campo] = $busca;
                }

                if ($service->save($data)) {
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Ocorreu um erro!');
                }

                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            } else {
                $this->flashMessenger()->addErrorMessage('Dados inseridos inválidos');
            }
        }
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $this->scriptsStyles();

        return new ViewModel(array('form' => $form, 'route' => $this->route, 'controller' => $this->controller, 'em' => $em, 'params' => $this->aditionalParameters()));
    }

    /**
     * 3 - Editar registro
     */
    public function editAction() {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        if (is_string($this->form))
            $form = new $this->form($dbAdapter);
        else
            $form = $this->form($dbAdapter);

        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);

        $repository = $this->getEm()->getRepository($this->entity)->find($param);

        if ($repository) {
            $array = array();
            foreach ($repository->toArray() as $key => $value) {
                if ($value instanceof \DateTime) {
                    $array[$key] = $value->format('d/m/Y H:i:s');
                } else {
                    $array[$key] = $value;
                }
            }

            $form->setData($array);

            if ($request->isPost()) {
                $form->setData($request->getPost());

                if ($form->isValid()) {

                    $service = $this->getServiceLocator()->get($this->service);

                    $data = $request->getPost()->toArray();
                    $data['id'] = (int) $param;

                    foreach ($data as $key => $valor) {
                        if (in_array($key, $this->data_elements)) {
                            $dataHora = explode(' ', $valor);
                            $data[$key] = new \DateTime(implode('-', array_reverse(explode('/', $dataHora[0]))) . ' ' . (isset($dataHora[1]) ? $dataHora[1] : ''));
                        }
                        if (in_array($key, $this->money_elements)) {
                            $data[$key] = number_format(str_replace(",", ".", str_replace(".", "", $valor)), 2, '.', '');
                        }
                    }

                    foreach ($this->external_objects as $campo => $entity) {
                        $busca = $this->getEm()->getRepository($entity)->find($data[$campo]);
                        $data[$campo] = $busca;
                    }

                    foreach ($this->file_elements as $key => $valor) {
                        if ($_FILES[$valor]['name'] != "") {
                            $File = $this->params()->fromFiles($valor);

                            $extension = pathinfo($File['name'], PATHINFO_EXTENSION);
                            $newName = time() . $extension;

                            $adapter = new \Zend\File\Transfer\Adapter\Http();
                            $adapter->addFilter('Rename', getcwd() . '/public/uploads/publicidades/' . $newName, $File['name']);
                            if ($adapter->receive($File['name'])) {
                                $data[$valor] = $newName;
                                $em = $this->getEm();
                                $entity = $em->getRepository($this->entity)->find($data['id']);
                                @unlink(getcwd() . '/public/uploads/' . $key . '/' . $entity->{'get' . ucfirst($valor)}());
                            }
                        }
                    }

                    if ($service->save($data)) {
                        $this->flashMessenger()->addSuccessMessage('Alterado com sucesso!');
                    } else {
                        $this->flashMessenger()->addErrorMessage('Ocorreu um erro!');
                    }

                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                } else {
                    $this->flashMessenger()->addErrorMessage('Dados inseridos inválidos');
                }
            }
        } else {
            $this->flashMessenger()->addInfoMessage('Registro não encontrado');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $this->scriptsStyles();

        return new ViewModel(array('form' => $form, 'route' => $this->route, 'controller' => $this->controller, 'id' => $param, 'em' => $em, 'params' => $this->aditionalParameters()));
    }

    /**
     * 4 - Excluir registro
     */
    public function deleteAction() {

        $service = $this->getServiceLocator()->get($this->service);
        $id = $this->params()->fromRoute('id', 0);

        if ($service->remove(array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 5 - Activate Deactivate
     */
    public function activesetAction() {
        $id = $this->params()->fromRoute('id', 0);
        $ativo = $this->params()->fromRoute('ativo');

        $em = $this->getEm();
//        $em->getFilters()->disable('softdeleteable'); // this was the problem when you use the soft delete extension you need to disable the filter if you want to reactivate deleted records
        $qb = $em->createQueryBuilder();
        $qb->update($this->entity, 'e');
        $qb->set('e.ativo', ':ativo');
        $qb->setParameter('ativo', $ativo);
        $qb->where("e.id = :id");
        $qb->setParameter('id', $id);

        if ($ativo)
            $acao = 'ativado';
        else
            $acao = 'desativado';

        if ($qb->getQuery()->execute()) {
            $this->flashMessenger()->addSuccessMessage('Registro ' . $acao . ' com sucesso!');
        } else {
            $this->flashMessenger()->addErrorMessage('Não foi possivel alterar o registro');
        }
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm() {
        if ($this->em == null) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }

    /**
     * @return String
     */
    public function getTituloTela() {
        return $this->tituloTela;
    }

    /**
     * @return String
     */
    public function arrayToJsString(array $array) {
        $retorno = '[';
        $aux = '';
        foreach ($array as $element) {
            $retorno .= $aux . "'" . $element . "'";
            $aux = ',';
        }
        $retorno .= ']';
        return $retorno;
    }

    public function scriptsStyles() {
        if (count($this->scripts_styles) > 0) {
            foreach ($this->scripts_styles as $script_style) {
                if (isset($script_style['file']))
                    $this->getServiceLocator()->get('viewhelpermanager')->get($script_style['type'])->{$script_style['function']}($this->request->getBasePath() . $script_style['file']);
                else if (isset($script_style['content']))
                    $this->getServiceLocator()->get('viewhelpermanager')->get($script_style['type'])->{$script_style['function']}($script_style['content']);
            }
        }
    }

}
