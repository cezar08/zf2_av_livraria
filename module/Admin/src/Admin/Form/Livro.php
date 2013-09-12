<?php

namespace Admin\Form;

use Zend\Form\Form;

class Livro extends Form {

    public function __construct($categorias, $idiomas, $editoras, $autores) {

        parent::__construct('livro');

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'titulo',
            'type' => 'Text',
            'options' => array(
                'label' => 'Titulo*',
                'label_attributes' => array('class' => 'label_form')

            ),
            
        ));
        $this->add(array(
            'name' => 'valor_livro',
            'type' => 'Text',
            'options' => array(
                'label' => 'Valor*',
                'label_attributes' => array('class' => 'label_form')                
            ),
        ));

        $this->add(array(
            'name' => 'quantidade',
            'type' => 'Text',
            'options' => array(
                'label' => 'Quantidade*',
                'label_attributes' => array('class' => 'label_form')

            ),
        ));

        $this->add(array(
            'name' => 'sinopse',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Sinopse*',
                'label_attributes' => array('class' => 'label_form')
            ),
        ));

        $this->add(array(
            'name' => 'edicao',
            'type' => 'Text',
            'options' => array(
                'label' => 'Edição*',
                'label_attributes' => array('class' => 'label_form')
            ),
        ));

        $this->add(array(
            'name' => 'isbn',
            'type' => 'Text',
            'options' => array(
                'label' => 'ISBN*',
                'label_attributes' => array('class' => 'label_form')
            ),
        ));

        $this->add(array(
            'name' => 'paginas',
            'type' => 'Text',
            'options' => array(
                'label' => 'Paginas*',
                'label_attributes' => array('class' => 'label_form')
            ),
        ));

        $this->add(array(
            'name' => 'ano',
            'type' => 'Text',
            'options' => array(
                'label' => 'Ano*',
                'label_attributes' => array('class' => 'label_form')
            ),
        ));


        $this->add(array(
            'name' => 'id_categoria',
            'type' => 'Select',
            'options' => array(
                'label' => 'Categoria*',
                'label_attributes' => array('class' => 'label_form'),
                'empty_option' => 'Selecione uma categoria',
                'value_options' => $this->mountMultiOptions($categorias, 'descricao')
            ),
        ));

        $this->add(array(
            'name' => 'id_idioma',
            'type' => 'Select',
            'options' => array(
                'label' => 'Idioma*',
                'label_attributes' => array('class' => 'label_form'),
                'empty_option' => 'Selecione um idioma',
                'value_options' => $this->mountMultiOptions($idiomas, 'descricao')
            ),
        ));

        $this->add(array(
            'name' => 'id_editora',
            'type' => 'Select',
            'options' => array(
                'label' => 'Editora*',
                'label_attributes' => array('class' => 'label_form'),
                'empty_option' => 'Selecione uma editora',
                'value_options' => $this->mountMultiOptions($editoras, 'nome')
            ),
        ));

        $this->add(array(
            'name' => 'autores',
            'type' => 'Select',
            'options' => array(
                'label' => 'Autor(es)*',
                'label_attributes' => array('class' => 'label_form'),
                'value_options' => $this->mountMultiOptions($autores, 'nome')
            ),
            'attributes' => array(
                'multiple' => 'multiple'
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'id' => 'submitbutton',
            ),
        ));
    }
    
    
    private function mountMultiOptions($collection, $column){
        $dataMultiOptions = array();
        
        foreach($collection as $row){
            $dataMultiOptions[$row['id']] = $row[$column];
        }
        
        return $dataMultiOptions;
    }

}
