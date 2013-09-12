<?php

namespace Admin\Form;

use Zend\Form\Form;

class Login extends Form {

    public function __construct() {

        parent::__construct('login');

        $this->setAttribute('method', 'POST');        
        $this->setAttribute('action', '/admin/auth/login');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        $this->add(array(
            'name' => 'login',
            'type' => 'Text',
            'options' => array(
                'label' => 'Login*',
            ),
        ));
        $this->add(array(
            'name' => 'senha',
            'type' => 'Password',
            'options' => array(
                'label' => 'Senha*',
            ),
        ));

      
      
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Entrar',
                'id' => 'submitbutton',
            ),
        ));
    }

}
