<?php

namespace Admin\Form;

use Zend\Form\Form;

class Usuario extends Form {

    public function __construct() {

        parent::__construct('usuario');

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'login',
            'type' => 'Text',
            'options' => array(
                'label' => 'Login',
            ),
        ));
        $this->add(array(
            'name' => 'senha',
            'type' => 'Text',
            'options' => array(
                'label' => 'Senha',
            ),
        ));

        $this->add(array(
            'name' => 'perfil',
            'type' => 'Select',
            'options' => array(
                'label' => 'Perfil',
                'empty_option' => 'Selecione um valor',
                'value_options' => array('Administrador' => 'Administrador', 
                    'Auxiliar Administrativo' => 'Auxiliar Administrativo')
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
