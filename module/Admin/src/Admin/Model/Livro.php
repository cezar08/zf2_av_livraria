<?php

namespace Admin\Model;

use Core\Db\Entity;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


class Livro extends Entity {

    protected $tableName = "Livro";
    protected $titulo;
    protected $valor_livro;
    protected $quantidade;
    protected $sinopse;
    protected $edicao;
    protected $isbn;
    protected $paginas;
    protected $ano;   
    protected $id_categoria;
    protected $id_idioma;
    protected $id_editora;

    /**
     * Filtros e validações
     * @return Zend/Input/Filter
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                    ),
                )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'titulo',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                        ),
                    ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 4,
                            'max' => 255,
                            ),
                        ),
                    ),
                )));
           
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'valor_livro',
                'required' => true,
                'validators' => array(
                             array('name' => 'Float'),
                    ),
                )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'quantidade',
                'required' => true,
                )));


            $inputFilter->add($factory->createInput(array(
                'name' => 'sinopse',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                        ),
                    ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 4,
                            'max' => 400,
                            ),
                        ),
                    ),
                )));


            $inputFilter->add($factory->createInput(array(
                'name' => 'edicao',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                        ),
                    ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 80,
                            ),
                        ),
                    ),
                )));


            $inputFilter->add($factory->createInput(array(
                'name' => 'isbn',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                        ),
                    ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 80,
                            ),
                        ),
                    ),
                )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'paginas',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                    ),
                )));



            $inputFilter->add($factory->createInput(array(
                'name' => 'ano',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                    ),
                )));



            $inputFilter->add($factory->createInput(array(
                'name' => 'id_categoria',
                'required' => true,
                )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'id_editora',
                'required' => true,
                )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'id_idioma',
                'required' => true,
                )));



            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}