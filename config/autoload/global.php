<?php
return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=myproject;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
        ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
        ),
    'acl' => array(
        'roles' => array(
            'Cliente' => null,
            'Auxiliar Administrativo' => 'Cliente',
            'Administrador' => 'Auxiliar Administrativo'
            ),
        'resources' => array(
            'Application\Controller\Index.index',
            'Application\Controller\Index.livro',
            'Application\Controller\Index.idioma',
            'Admin\Controller\Auth.index',
            'Admin\Controller\Auth.login',
            'Admin\Controller\Auth.logout',
            'Admin\Controller\Autores.index',
            'Admin\Controller\Autores.save',
            'Admin\Controller\Autores.delete',
            'Admin\Controller\Categorias.index',
            'Admin\Controller\Categorias.save',
            'Admin\Controller\Categorias.delete',
            'Admin\Controller\Editoras.index',
            'Admin\Controller\Editoras.save',
            'Admin\Controller\Editoras.delete',
            'Admin\Controller\Idiomas.index',
            'Admin\Controller\Idiomas.save',
            'Admin\Controller\Idiomas.delete',
            'Admin\Controller\Livros.index',
            'Admin\Controller\Livros.save',
            'Admin\Controller\Livros.delete',
            
            'Admin\Controller\Usuarios.index',
            'Admin\Controller\Usuarios.add',
            'Admin\Controller\Usuarios.update',
            'Admin\Controller\Usuarios.delete',
            ),
'privilege' => array(
    'Cliente' => array(
        'allow' => array(
            'Application\Controller\Index.index',
            'Admin\Controller\Auth.index',
            'Admin\Controller\Auth.login',
            'Admin\Controller\Auth.logout',
            'Application\Controller\Index.livro',                                        
            'Application\Controller\Index.idioma',
            )
        ),
    'Auxiliar Administrativo' => array(
        'allow' => array(
          'Admin\Controller\Autores.index',
          'Admin\Controller\Autores.save',
          'Admin\Controller\Categorias.index',
          'Admin\Controller\Categorias.save',
          'Admin\Controller\Editoras.index',
          'Admin\Controller\Editoras.save',
          'Admin\Controller\Idiomas.index',
          'Admin\Controller\Idiomas.save',
          'Admin\Controller\Livros.index',
          'Admin\Controller\Livros.save',          
          )
        ),
    'Administrador' => array(
        'allow' => array(
            'Admin\Controller\Autores.delete',
            'Admin\Controller\Categorias.delete',
            'Admin\Controller\Editoras.delete',
            'Admin\Controller\Idiomas.delete',
            'Admin\Controller\Livros.delete',
            'Admin\Controller\Usuarios.index',
            'Admin\Controller\Usuarios.add',
            'Admin\Controller\Usuarios.update',
            'Admin\Controller\Usuarios.delete',
            )
        ),
    )
)
);