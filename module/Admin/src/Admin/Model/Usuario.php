<?php

namespace Admin\Model;

use Core\Db\Entity;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


class Usuario extends Entity {

    protected $tableName = "Usuario";

    protected $login;
    protected $senha;
    protected $perfil;

 

}