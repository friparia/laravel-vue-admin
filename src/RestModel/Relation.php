<?php
namespace Friparia\RestModel;

use Illuminate\Support\Str;

class Relation extends Fluent
{
    protected $_model;
    protected $_descriptor;
    protected $_searchFields;

    public function __construct($type, $name, $model)
    {
        parent::__construct($type, $name);
        $this->_model = new $model;
    }

    public function isMany()
    {
        if ($this->_type == 'many') {
            return true;
        }
        return false;
    }

    public function canSwitch(){
	    return false;
    }

    public function elements()
    {
        if ($this->type == 'many') {
            return $this->_model->get();
        }
    }

    public function getDescriptor()
    {
        if (isset($this->_descriptor[0])) {
            return $this->_descriptor[0];
        }
        return 'id';
    }

    public function getOptions()
    {
        $res = [];
        foreach ($this->_model->all() as $one) {
            $descriptor = $this->getDescriptor();
            $res[$one->id] = $one->$descriptor;
        }
        return $res;
    }

    public function search($data, $model, $q)
    {
        return $data->join($this->_model->getTable(), function($join) use ($q, $model){
            $join->on($this->_model->getTable().".id", '=', $model->getTable().".".$this->_name.'_id');
        })->where(function($query) use($q) {
            if (!is_null($this->_searchFields)) {
                $fields = $this->_searchFields;
            }else{
                $fields = [$this->getDescriptor()];
            }
            foreach($fields as $field){
                $query->orWhere($this->_model->getTable().'.'.$field, 'LIKE', '%'.$q.'%');
            }
        })->select($model->getTable().'.*');
    }
    // public $name;
    // public $related;
    // public $foreignKey;
    // public $otherKey = "id";
    // public $localKey = "id";
    // public $type;
    // public $blueprint;
    // public $table;
    // const BELONGS_TO = 1;
    // const HAS_ONE = 2;
    // const HAS_MANY = 3;
    // const MANY_TO_MANY = 4;
    // const BELONGS_TO_MANY = 5;
    //
    // public function __construct($name, $blueprint){
    //     $this->name = $name;
    //     $this->blueprint = $blueprint;
    // }
    //
    // public function belongsTo($parent, $foreignKey = "", $otherKey = ""){
    //     $this->related = $parent;
    //     if($foreignKey == ""){
    //         $foreignKey = $this->name . "_id";
    //     }
    //     if($otherKey == ""){
    //         $otherKey = "id";
    //     }
    //     $this->foreignKey = $foreignKey;
    //     $this->otherKey = $otherKey;
    //     $this->type = self::BELONGS_TO;
    //     $this->blueprint->integer($foreignKey);
    //     return $this;
    // }
    //
    // public function hasOne($parent, $foreignKey = "", $localKey = ""){
    //     $this->related = $parent;
    //     if($foreignKey == ""){
    //         $foreignKey = $this->name . "_id";
    //     }
    //     if($localKey == ""){
    //         $localKey = "id";
    //     }
    //     $this->foreignKey = $foreignKey;
    //     $this->localKey = $localKey;
    //     $this->type = self::HAS_ONE;
    //     return $this;
    // }
    //
    // //'App\Comment', 'foreign_key', 'local_key'
    // public function hasMany($parent, $foreignKey = "", $localKey = ""){
    //     $this->related = $parent;
    //     if($foreignKey == ""){
    //         $foreignKey = $this->name . "_id";
    //     }
    //     if($localKey == ""){
    //         $localKey = "id";
    //     }
    //     $this->foreignKey = $foreignKey;
    //     $this->localKey = $localKey;
    //     $this->type = self::HAS_MANY;
    //     return $this;
    // }
    //
    // //'App\Role', 'role_user', 'user_id', 'role_id'
    // public function belongsToMany($related, $table = "", $foreignKey = "", $otherKey = ""){
    //     $this->related = $related;
    //     $this->table = $this->getJoinTable($table);
    //     if($foreignKey == ""){
    //         $foreignKey = Str::singular($this->blueprint->getTable()) . "_id";
    //     }
    //     if($otherKey == ""){
    //         $otherKey = Str::singular(class_basename($related)) . "_id";
    //     }
    //     $this->foreignKey = $foreignKey;
    //     $this->otherKey = $otherKey;
    //     $this->type = self::BELONGS_TO_MANY;
    //     return $this;
    // }
    //
    // //'App\Role', 'role_user', 'user_id', 'role_id'
    // public function hasManyToMany($related, $table = "", $foreignKey = "", $otherKey = ""){
    //     $this->related = $related;
    //     $this->table = $this->getJoinTable($table);
    //     if($foreignKey == ""){
    //         $foreignKey = Str::singular($this->blueprint->getTable()) . "_id";
    //     }
    //     if($otherKey == ""){
    //         $otherKey = $this->name . "_id";
    //     }
    //     $this->foreignKey = $foreignKey;
    //     $this->otherKey = $otherKey;
    //     $this->type = self::MANY_TO_MANY;
    //     return $this;
    // }
    //
    // protected function getJoinTable($table = ""){
    //     if($table == ""){
    //         $arr = [Str::singular($this->blueprint->getTable()), $this->name];
    //         sort($arr);
    //         $table = implode("_", $arr);
    //     }
    //     return $table;
    // }
    //

}

