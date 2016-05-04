<?php
namespace Friparia\Admin;

use Illuminate\Database\Eloquent\Model as LaravelModel;

abstract class Model extends LaravelModel
{
    protected $slug;
    protected $unlistable = [];
    protected $unshowable = [];
    protected $uncreatable = [];
    protected $uneditable = [];
    protected $filterable = [];
    protected $searchable = [];

    protected $guarded = [];

    public $timestamps = false;
    protected $fields;
    //each boolean
    //color string
    //icon string
    //type link/confirm/modal
    //url string
    protected $actions = [];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fields = new Blueprint($this->getTable());
        $this->construct();
        $this->fields->increments($this->primaryKey);

        // $this->test2 = 
    }

    protected function construct()
    {
        //version 1
        //$this->fields->append((new Field())->string(''))
        //$this->fields->append((new CharField())->description())
    }

    /**
     * return all the fields in database
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function getRelations()
    {
        return $this->fields->getRelations();
    }


    public function getManyToManyRelation(){
        $relations = [];
        foreach($this->getRelations() as $relation){
            if($relation['type'] == Relation::MANY_TO_MANY){
                $relations[] = $relation;
            }
        }
        return $relations;
    }

    public function getColumns()
    {
        return $this->fields->getColumns();
    }

    public function getListableColumns(){
        $columns = [];
        $this->unlistable[] = 'id';
        foreach($this->getColumns() as $column){
            if(!in_array($column['name'], $this->unlistable)){
                $columns[] = $column;
            }
        }
        return $columns;
    }

    public function getFilterableColumns(){
        $columns = [];
        foreach($this->getColumns() as $column){
            if(in_array($column['name'], $this->filterable)){
                $columns[] = $column;
            }
        }
        return $columns;
    }

    public function getSearchableColumns(){
        $columns = [];
        foreach($this->getColumns() as $column){
            if(in_array($column['name'], $this->searchable)){
                $columns[] = $column;
            }
        }
        return $columns;
    }

    public function getShowableColumns(){}

    public function getEditableColumns(){
        $columns = [];
        foreach($this->getColumns() as $column){
            $name = $column->name;
            if(!in_array($name, $this->uneditable) && $name != 'id'){
                $columns[] = $column;
            }
        }
        return $columns;
    }

    public function getValue($name){
        return $this->$name;
    }

    public function getRawValue($name){
        return $this->$name;
    }

    public function getAllActions(){
        return array_merge(['create', 'update', 'delete'], array_keys($this->actions));
    }

    public function getEachActions(){
        $actions = [];
        foreach($this->actions as $action => $value){
            if(isset($value['each'])){
                if($value['each']){
                    $actions[$action] = $value;
                }
            }else{
                $actions[$action] = $value;
            }
        }
        return $actions;
    }

    public function getModalActions(){
        $actions = [];
        foreach($this->actions as $action => $value){
            if(isset($value['type']) && $value['type'] == "modal"){
                $actions[] = $action;
            }
        }
        return $actions;
    }

    public function getBatchActions(){
        return [];
    }

    public function getSingleActions(){
        $actions = [];
        foreach($this->actions as $action => $value){
            if(isset($value['single'])){
                if($value['single']){
                    $actions[$action] = $value;
                }
            }
        }
        return $actions;
    }

    public function getValueGroups($column){
        $data = [];
        foreach(self::all()->groupBy($column) as $key => $item){
            $data[$key] = $item[0][$column];
        }
        return $data;
    }

    public function canFilterColumn($column){
        if(in_array($column, $this->filterable)){
            return true;
        }
        return false;
    }

    public function canListColumn($column){}

    public function canShowColumn($column){}

    public function canCreateColumn($column){}

    public function canEditColumn($column){}

    static public function search($q){}

    public function getRules(){
        return [];
    }

    public function getValidatorMessages(){
        return [];
    }

    public function getCustomValidatorCallback(){
        return [];
    }


    public function newFromBuilder($attributes = [], $connection = null){
        $model = parent::newFromBuilder($attributes, $connection);
        foreach($this->fields->getRelations() as $key => $relation) {
            if ($relation['type'] == Relation::BELONGS_TO) {
                $relation = $model->belongsTo($relation['related'], $relation['foreignKey'], $relation['otherKey']);
                $model->$key = $relation->getResults();
                $model->setRelation($key, $relation);
            }else if ($relation['type'] == Relation::MANY_TO_MANY || $relation['type'] == Relation::BELONGS_TO_MANY) {
                $relation = $model->belongsToMany($relation['related'], $relation['table'], $relation['foreignKey'], $relation['otherKey']);
                $model->$key = $relation->getResults();
                $model->setRelation($key, $relation);
            }else if ($relation['type'] == Relation::HAS_MANY){
                $relation = $model->hasMany($relation['related'], $relation['foreignKey'], $relation['localKey']);
                $model->$key = $relation->getResults();
                $model->setRelation($key, $relation);
            }else if ($relation['type'] == Relation::HAS_ONE){
                $relation = $model->hasOne($relation['related'], $relation['foreignKey'], $relation['localKey']);
                $model->$key = $relation->getResults();
                $model->setRelation($key, $relation);
            }
        }
        return $model;
    }


    public function getDirty(){
        $dirty = parent::getDirty();
        foreach(array_keys($this->relations) as $relation){
            unset($dirty[$relation]);
        }

        return $dirty;
    }


}
