<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Core\Db\TableGateway;

class CoreController extends AbstractActionController {

    /**
     * Returns a TableGateway
     *
     * @param  string $table
     * @return TableGateway
     */
    protected function getTable($table) {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $tableGateway = new TableGateway($dbAdapter, $table, new $table);
        $tableGateway->initialize();

        return $tableGateway;
    }



}
