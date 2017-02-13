<?php
namespace Friparia\RestModel;

class Fluent
{
    protected $_name;
    protected $_type;
    protected $_description;

    public function __construct($type, $name){
        $this->_type = $type;
        $this->_name = $name;
    }

    public function __get($name){
        $name = "_".$name;
        if(!is_null($this->$name)){
            return $this->$name;
        }
        return null;
    }

    public function __call($method, $parameters){
        $name = "_".$method;
        if(count($parameters) == 0){
            $this->$name = true;
        }else if(count($parameters) == 1){
            $this->$name = $parameters[0];
        }else{
            $this->$name = $parameters;
        }
        return $this;
    }
}

