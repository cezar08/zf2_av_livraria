<?php

return array(
    'Autor' => array(
        'create' => "CREATE TABLE Autor (
					id int(10) NOT NULL AUTO_INCREMENT,
					nome varchar(80) NOT NULL,
					sobrenome varchar(80) NOT NULL,
					PRIMARY KEY (id)); 
					",
        'drop' => "DROP TABLE Autor;"
    ),
    'Categoria' => array(
        'create' => "
			CREATE TABLE Categoria (
			id int(10) NOT NULL AUTO_INCREMENT,
			descricao varchar(255) NOT NULL,
			PRIMARY KEY (id));",
        'drop' =>'drop table Categoria;'
    ),
  


);





