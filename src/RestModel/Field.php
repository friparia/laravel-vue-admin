<?php
namespace Friparia\RestModel;

class Field extends Fluent
{
    protected $_extended;
    protected $_password;
    protected $_switchable;
    protected $_image;
    protected $_file;

    public function canSwitch(){
        return $this->_switchable;
    }


    public function isExtended(){
        return is_null($this->_extended) ? false : $this->_extended;
    }

    public function getEnumValue($key){
        return $this->_values[0][$key];
    }

    public function isPassword(){
        return is_null($this->_password) ? false : $this->_password;
    }

    public function isFile(){
        return is_null($this->_file) ? false : $this->_file;
    }

    public function isImage(){
        return is_null($this->_image) ? false : $this->_image;
    }

    public function getOptions(){
        if($this->_type == 'boolean'){
            return ['1' => '是', '0' => '否'];
        }
        return $this->_values[0];
    }



    public function getMigrationDescription(){
        $parameters = [];
        $pre_defined_types = [
            'bigIncrements',
            'bigInteger',
            'binary',
            'boolean',
            'char',
            'date',
            'dateTime',
            'dateTimeTz',
            'decimal',
            'double',
            'enum',
            'float',
            'integer',
            'ipAddress',
            'json',
            'jsonb',
            'longText',
            'macAddress',
            'mediumInteger',
            'mediumText',
            'morphs',
            'smallInteger',
            'string',
            'text',
            'time',
            'timeTz',
            'tinyInteger',
            'timestamp',
            'timestampTz',
            'uuid',
        ];
        $pre_defined_functions = [
            'default'
        ];

        $functions = [];
        if(in_array($this->_type, $pre_defined_types)){
            $method = $this->_type;
            foreach($pre_defined_functions as $function){
                $name = "_".$function;
                if(isset($this->$name)){
                    $functions[$function] = $this->$name;
                }
            }
            return [$method, $this->_name, $parameters, $functions];
        }
        return false;
    }

    public function toArray(){
        return [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
        ];
    }

}
