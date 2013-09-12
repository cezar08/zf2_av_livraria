<?php

namespace Admin\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


use Core\Db\Entity;

class AutorLivro extends Entity {

    protected $tableName = "AutorLivro";    
    protected $id_autor;
    protected $id_livro;


}

?>
