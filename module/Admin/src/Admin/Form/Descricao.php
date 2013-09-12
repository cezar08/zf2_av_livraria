<?php

namespace Admin\Form;

use Zend\Form\Form;

class Descricao extends Form {

    public function __construct() {

        parent::__construct('descricao');

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'descricao',
            'type' => 'Text',
            'options' => array(
                'label' => 'Descirção*',
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
