<?php
namespace Friparia\Admin;

use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class Relation extends Fluent
{
    public $name;
    public $related;
    public $foreignKey;
    public $otherKey = "id";
    public $type;
    public $blueprint;
    public $table;
    const MANY_TO_ONE = 1;
    const ONE_TO_ONE = 2;
    const ONE_TO_MANY = 3;
    const MANY_TO_MANY = 4;

    public function __construct($name, $blueprint){
        $this->name = $name;
        $this->blueprint = $blueprint;
    }

    public function belongsTo($parent, $foreignKey = "", $otherKey = ""){
        $this->related = $parent;
        if($foreignKey == ""){
            $foreignKey = $this->name . "_id";
        }
        if($otherKey == ""){
            $otherKey = "id";
        }
        $this->foreignKey = $foreignKey;
        $this->otherKey = $otherKey;
        $this->type = self::MANY_TO_ONE;
        $this->blueprint->integer($foreignKey);
        return $this;
    }

    public function hasOne($parent, $foreignKey = "", $otherKey = ""){
        //TODO
    }

    public function hasMany(){
        //TODO
    }

    public function hasManyToMany($related, $table = "", $foreignKey = "", $otherKey = ""){
        $this->related = $related;
        $related = Str::snake(class_basename($related));
        if($table == ""){
            $arr = [$related, $this->name];
            sort($arr);
            $table = implode("_", $arr);
        }
        $this->table = $table;
        if($foreignKey == ""){
            $foreignKey = $this->name . "_id";
        }
        if($otherKey == ""){
            $otherKey = $related . "_id";
        }
        $this->foreignKey = $foreignKey;
        $this->otherKey = $otherKey;
        $this->type = self::MANY_TO_MANY;
        return $this;
    }

}

