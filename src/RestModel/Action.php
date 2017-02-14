<?php
namespace Friparia\RestModel;

class Action extends Fluent
{
    protected $_method = 'GET';
    protected $_style = [];

    protected $_single = false;
    protected $_each = false;

    protected $_form = false;

    protected $_fields = [];

    public function isSingle(){
        return $this->_single;
    }

    public function isEach(){
        return $this->_each;
    }

    public function toArray(){
        return [
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->type,
                'method' => $this->method,
                'style' => $this->style,
                'fields' => $this->fields,
                'is_single' => $this->single,
                'is_form' => $this->form,
                'is_each' => $this->each,
            ];

    }
}

