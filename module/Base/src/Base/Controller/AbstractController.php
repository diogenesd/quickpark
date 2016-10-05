<?php

namespace Base\Controller;

/**
 * Description of AbstractController
 *
 * @author mauricioschmitz
 */
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController {

    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    protected $data_elements = array();
    protected $file_elements = array();
    protected $money_elements = array();
    protected $money3casas_elements = array();
    protected $group_elements = array('field' => '', 'fields' => array());
    protected $external_objects = array();
    protected $default_external_objects = array();
    protected $success_insert_message = 'Cadastrado com sucesso!';
    protected $error_insert_message = 'Ocorreu um erro!';
    protected $invalid_insert_message = 'Dados inseridos inválidos!';
    protected $success_edit_message = 'Altarado com sucesso!';
    protected $error_edit_message = 'Ocorreu um erro!';
    protected $invalid_edit_message = 'Dados inseridos inválidos!';
    protected $aditional_insert_method;
    protected $aditional_edit_method;
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
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $this->layout()->tituloTela = $this->tituloTela . ' | Adicionar';

        if (is_string($this->form))
            $form = new $this->form($em);
        else
            $form = $this->form($em);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->service);
                $data = $request->getPost()->toArray();
                $groupAux = '';
                if (isset($this->group_elements['field']))
                    $data[$this->group_elements['field']] = '';

                foreach ($data as $key => $valor) {
                    if (in_array($key, $this->data_elements)) {
                        $dataHora = explode(' ', $valor);
                        $data[$key] = new \DateTime(implode('-', array_reverse(explode('/', $dataHora[0]))) . ' ' . (isset($dataHora[1]) ? $dataHora[1] : ''));
                    }
                    if (in_array($key, $this->money_elements)) {
                        $data[$key] = number_format(str_replace(",", ".", str_replace(".", "", $valor)), 2, '.', '');
                    }
                    if (in_array($key, $this->money3casas_elements)) {
                        $data[$key] = number_format(str_replace(",", ".", str_replace(".", "", $valor)), 3, '.', '');
                    }
                    if (in_array($key, $this->group_elements['fields'])) {
                        $data[$this->group_elements['field']] = $data[$this->group_elements['field']] . $groupAux . $valor;
                        $groupAux = '<|>';
                    }
                }

                foreach ($this->external_objects as $campo => $entity) {

                    $busca = $this->getEm()->getRepository($entity)->find($data[$campo]);
                    $data[$campo] = $busca;
                }

                $aditionalParams = $this->aditionalParameters();
                foreach ($this->default_external_objects as $campo) {
                    if (!empty($aditionalParams[$campo])) {
                        $data[$campo] = $aditionalParams[$campo];
                    }
                }

                foreach ($this->file_elements as $key => $valor) {
                    if ($_FILES[$valor]['name'] != "") {
                        $File = $this->params()->fromFiles($valor);

                        $extension = pathinfo($File['name'], PATHINFO_EXTENSION);
                        $newName = time() . '.' . $extension;

                        $adapter = new \Zend\File\Transfer\Adapter\Http();
                        $adapter->addFilter('Rename', getcwd() . '/public/uploads/publicidades/' . $newName, $File['name']);
                        if ($adapter->receive($File['name'])) {
                            $data[$valor] = $newName;
                        }
                    }
                }
                if ($entity = $service->save($data)) {
                    $this->flashMessenger()->addSuccessMessage($this->success_insert_message);
                } else {
                    $this->flashMessenger()->addErrorMessage($this->error_insert_message);
                }
                if ($this->aditional_insert_method) {
                    $data['entity'] = $entity;
                    $this->{$this->aditional_insert_method}($data);
                }
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            } else {
                $this->flashMessenger()->addErrorMessage($this->invalid_insert_message);
            }
        }


        $this->scriptsStyles();

        return new ViewModel(array('form' => $form, 'route' => $this->route, 'controller' => $this->controller, 'em' => $em, 'params' => $this->aditionalParameters()));
    }

    /**
     * 3 - Editar registro
     */
    public function editAction() {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if (is_string($this->form))
            $form = new $this->form($em);
        else
            $form = $this->form($em);

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
                    $groupAux = '';
                    if (isset($this->group_elements['field']))
                        $data[$this->group_elements['field']] = '';

                    foreach ($data as $key => $valor) {
                        if (in_array($key, $this->data_elements)) {
                            $dataHora = explode(' ', $valor);
                            $data[$key] = new \DateTime(implode('-', array_reverse(explode('/', $dataHora[0]))) . ' ' . (isset($dataHora[1]) ? $dataHora[1] : ''));
                        }
                        if (in_array($key, $this->money_elements)) {
                            $data[$key] = number_format(str_replace(",", ".", str_replace(".", "", $valor)), 2, '.', '');
                        }
                        if (in_array($key, $this->money3casas_elements)) {
                            $data[$key] = number_format(str_replace(",", ".", str_replace(".", "", $valor)), 3, '.', '');
                        }
                        if (in_array($key, $this->group_elements['fields'])) {
                            $data[$this->group_elements['field']] = $data[$this->group_elements['field']] . $groupAux . $valor;
                            $groupAux = '<|>';
                        }
                    }

                    foreach ($this->external_objects as $campo => $entity) {
                        $busca = $this->getEm()->getRepository($entity)->find($data[$campo]);
                        $data[$campo] = $busca;
                    }
                    $aditionalParams = $this->aditionalParameters();
                    foreach ($this->default_external_objects as $campo) {
                        if (!empty($aditionalParams[$campo])) {
                            $data[$campo] = $aditionalParams[$campo];
                        }
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

                    if ($entity = $service->save($data)) {
                        $this->flashMessenger()->addSuccessMessage($this->success_edit_message);
                    } else {
                        $this->flashMessenger()->addErrorMessage($this->error_edit_message);
                    }
                    if ($this->aditional_edit_method) {
                        $data['entity'] = $entity;
                        $this->{$this->aditional_edit_method}($data);
                    }
                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                } else {
                    var_dump($form->getMessages());
                    $this->flashMessenger()->addErrorMessage($this->invalid_edit_message);
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
        $active = $this->params()->fromRoute('active');

        $em = $this->getEm();
        $qb = $em->createQueryBuilder();
        $qb->update($this->entity, 'e');
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
                    $this->getServiceLocator()->get('viewhelpermanager')->get($script_style['type'])->{$script_style['function']}((!isset($script_style['external']) ? $this->request->getBasePath() : '') . $script_style['file']);
                else if (isset($script_style['content']))
                    $this->getServiceLocator()->get('viewhelpermanager')->get($script_style['type'])->{$script_style['function']}($script_style['content']);
            }
        }
    }

    /**
     * @return Json of file name
     */
    public function uploadeditorAction() {
        $message = [];
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];
                $destination = getcwd() . '/public/uploads/editor/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                $message['resposta'] = $this->request->getBasePath() . '/uploads/editor/' . $filename; //change this URL
            } else {
                $message['resposta'] = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            }
        } else {
            $message['resposta'] = 'No file!';
        }

        return new JsonModel($message);
    }

    /**
     * Lista das imagens já enviadas
     */
    public function galeriaeditorAction() {
        echo '<div class="col-md-12"><span class="h4">Clique na imagem desejada:</span></div>';
        $dir = getcwd() . '/public/uploads/editor/';
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (filetype($dir . $file) == 'file' && $file != '.DS_Store' && $file != '.gitignore') {
                        $imagePath = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost() . $this->request->getBasePath() . '/uploads/editor/' . $file;

                        echo '<div class="col-md-3">'
                        . '     <a href="#" onclick="$(\'.note-image-url\').val(\'' . $imagePath . '\'); $(\'.note-image-btn\').removeClass(\'disabled\').removeAttr(\'disabled\')">'
                        . '       <img src="' . $this->request->getBasePath() . '/uploads/editor/' . $file . '" style="max-width:90px">'
                        . '     </a>'
                        . '     <!--<a href="#"><i class="fa fa-trash"></i></a>-->'
                        . '   </div>';
                    }
                }
                closedir($dh);
            }
        }
        die();
    }

    /**
     * @return String
     */
    public static function titleLink($str) {
        $str = strtolower(utf8_decode($str));
        $i = 1;
        $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
        $str = preg_replace("/([^a-z0-9])/", '-', utf8_encode($str));
        while ($i > 0)
            $str = str_replace('--', '-', $str, $i);
        if (substr($str, -1) == '-')
            $str = substr($str, 0, -1);
        return $str;
    }

    /**
     * @return String
     */
    public static function datePt($id) {
        $array = array('', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
        return $array[$id];
    }

}
