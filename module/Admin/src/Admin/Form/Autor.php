<?php

namespace Admin\Form;

use Zend\Form\Form;

class Autor extends Form {

    public function __construct() {

        parent::__construct('usuario');

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
                'label' => 'Primeiro nome',
            ),
        ));
        $this->add(array(
            'name' => 'sobrenome',
            'type' => 'Text',
            'options' => array(
                'label' => 'Sobrenome',
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
