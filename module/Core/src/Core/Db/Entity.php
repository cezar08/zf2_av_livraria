<?php

namespace Core\Db;


abstract class Entity
{
    /**
     * 
     *
     * @var string
     */
    protected $pk = 'id';

    /**
     * The table name at the database
     *
     * @var string
     */
    protected $tableName;

    /**
    *Filters
    *
    */
    protected $inputFilter = null;
    

    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * 
     * @param string $key
     * @param string $value
     * @return void
     */
    public function __set($key, $value) 
    {
             
        $this->$key = $value;
    }

    /**
     * @param string $key
     * @return mixed 
     */
    public function __get($key) 
    {

        return $this->$key;
    }

    /**
     * 
     *
     * @param array $data
     * @return void
     */
    public function setData($data)
    {

        foreach($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    /**
     * 
     *
     * @return array
     */
    public function getData()
    {
        $data = get_object_vars($this); 
        unset($data['pk']);
        unset($data['inputFilter']);
        unset($data['tableName']);    
  
        return array_filter($data);
    }

    /**
     * Usado pelo TableGateway
     *
     * @param array $data
     * @return void
     */
    public function exchangeArray($data)
    {
        $this->setData($data);
    }

    /**
     * Usado pelo TableGateway
     *
     * @param array $data
     * @return void
     */
    public function getArrayCopy()
    {
        return $this->getData();
    }

    /**
     * Usado pelo TableGateway
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getData();
    }
}
