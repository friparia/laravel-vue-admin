<?php
namespace Friparia\Admin;

class Action extends Fluent
{
    protected $_color = 'default';
    protected $_icon;
    protected $_single;
    protected $_each;

    public function __get($name){
        $name = "_".$name;
        if(in_array($name, ['_description', '_color', '_icon'])){
            $array = $this->$name;
            return $array[0];
        }
        if(!is_null($this->$name)){
            return $this->$name;
        }
        return null;
    }

    public function isSingle(){
        return is_null($this->_single) ? false : $this->_single;
    }

    public function isEach(){
        return is_null($this->_each) ? false : $this->_each;
    }
}

