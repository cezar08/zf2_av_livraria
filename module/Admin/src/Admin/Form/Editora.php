<?php

namespace Admin\Form;

use Zend\Form\Form;

class Editora extends Form {

    public function __construct() {

        parent::__construct('editora');

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        $this->add(array(
            'name' => 'nome',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nome*',
            ),
        ));

        $this->add(array(
            'name' => 'telefone',
            'type' => 'Text',
            'options' => array(
                'label' => 'Telefone*',
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

}
