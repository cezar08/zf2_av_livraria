<?php

/**
 * Testa a Model Autor
 * @category Admin
 * @package Model
 * @author Cezar <cezar08@unochapeco.edu.br>
 *
 */

namespace Admin\Model;

use Core\Test\TestCase;
use Admin\Model\Autor as Autor;
use Zend\InputFilter\InputFilterInterface;

/**
 * @group Model
 */
class AutorTest extends TestCase {

    public function testGetInputFilter() {
        $Autor = new Autor();
        $if = $Autor->getInputFilter();
        //Verifica se existe filtros
        $this->assertInstanceOf("Zend\InputFilter\InputFilter", $if);

        return $if;
    }

    /**
     * @depends testGetInputFilter
     */

    public function testInputFilterValid($if) {

        //Testa os filtros

        $this->assertEquals(3, $if->count());

        $this->assertTrue($if->has('id'));
        $this->assertTrue($if->has('nome'));
        $this->assertTrue($if->has('sobrenome'));
        
    }

        /**
        * @expectedException \Exception
        * @expectedExceptionMessage Entrada inválida
        */
        public function testInputFilterInvalido()
        {

            $Autor = new Autor();
            //sobrenome só pode ter 100 caracteres
            $Autor->sobrenome = 'asdfasdfasdf asdfasdfasdfasf asdfasdfadfasdfasdfasdfa sadfasdfjkasdklfjasljfaljfasf
            asdjklfklasfjklasjklfjklasdfjkl jklsdfjklaskljdfajklsdklfasjkld 
            sdklfasdfjklasjklfasklfjklasdf sdklfjasfklasjklfjklasdfjkl sdklfajklsfjklasjklf sdklfasdfjklasjklfasklfjklasdfsdlsdkljfklajsd
            sdjfklajklsdjfsdkl';
        }

        /**
        * Teste de inserção de um autor válido
        */
        public function testInsert()
        {
            $Autor = $this->addAutor();

            $saved = $this->getTable('Admin\Model\Autor')->save($Autor);

        //testa o filtro de tags e espaços
            $this->assertEquals('PEDRO', $saved->nome);
        //testa o auto increment da chave primária
            $this->assertEquals(1, $saved->id);
        }

        /**
        * @expectedException \Exception
        * @expectedExceptionMessage Entrada inválida
        */
        public function testInsertInvalido()
        {
            $Autor = new Autor();
            $Autor->nome = 'teste';
            $Autor->sobrenome = '';

            $saved = $this->getTable('Admin\Model\Autor')->save($Autor);
        }

        public function testUpdate()
        {
            $tableGateway = $this->getTable('Admin\Model\Autor');
            $Autor = $this->addAutor();

            $saved = $tableGateway->save($Autor);
            $id = $saved->id;

            $this->assertEquals(1, $id);

            $Autor = $tableGateway->get($id);
            $this->assertEquals('PEDRO', $Autor->nome);

            $Autor->nome = 'João';
            $updated = $tableGateway->save($Autor);

            $Autor = $tableGateway->get($id);
            $this->assertEquals('JOÃO', $Autor->nome);
        }

        /**
        * @expectedException \Exception
        * @expectedExceptionMessage Linha inexistente
        */
        public function testDelete()
        {
            $tableGateway = $this->getTable('Admin\Model\Autor');
            $Autor = $this->addAutor();

            $saved = $tableGateway->save($Autor);
            $id = $saved->id;

            $deleted = $tableGateway->delete($id);
            $this->assertEquals(1, $deleted); //numero de linhas excluidas

            $tableGateway->get($id);
        }

        private function addAutor()
        {
            $Autor = new Autor();
            $Autor->nome = 'Pedro';
            $Autor->sobrenome = 'Silva';
            

            return $Autor;
        }


}

?>
