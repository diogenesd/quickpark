<?php
namespace Admin\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
/**
 * Description of FuncionarioService
 *
 * @author rodrigoheinzle
 */
class FuncionarioService extends AbstractService{
    public function __construct(EntityManager $em) {
        $this->entity = 'Admin\Entity\Funcionario';
        parent::__construct($em);
    }
}
