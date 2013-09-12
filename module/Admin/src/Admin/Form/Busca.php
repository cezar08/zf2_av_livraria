<?php

namespace Admin\Form;

use Zend\Form\Form;

class Busca extends Form {

    public function __construct() {

        parent::__construct('busca');

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '');
         
        $this->add(array(
            'name' => 'busca',
            'type' => 'Text',
            'options' => array(
                'label' => 'Busca',
            ),
            'attributes' => array(
                'placeholder' => 'Buscar por...'
            ),
        ));
              
      
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Buscar',
                'id' => 'submitbutton',
            ),
        ));
    }

}
