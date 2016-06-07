<?php
namespace Friparia\Admin;

use Illuminate\Database\Eloquent\Model as LaravelModel;

use Illuminate\Support\Fluent;

abstract class Model extends LaravelModel
{
    protected $slug;
    protected $unlistable = [];
    protected $unshowable = [];
    protected $uncreatable = [];
    protected $uneditable = [];
    protected $filterable = [];
    protected $searchable = [];
    protected $switchable = [];
    protected $extended = [];
    protected $order = [];

    protected $guarded = [];
    protected $title = "";

    public $timestamps = true;
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

    //need reconstruct
    public function getColumns()
    {
        $cols = $this->fields->getColumns();
        $relatedKey = [];
        foreach($this->getRelations() as $relation){
            if($relation->type == Relation::BELONGS_TO){
                $relatedKey[] = $relation->foreignKey;
            }
        }
        $columns = [];
        foreach($cols as $column){
            if(!in_array($column->name, $relatedKey)){
                $columns[] = $column;
            }
        }

        foreach($this->extended as $extended){
            if(!$description = $this->getColumnDescription($extended)){
                $description = $extended;
            }
            $columns[] = new Fluent([
                'name' => $extended,
                'type' => 'extended',
                'description' => $description
            ]);
        }
        return $columns;
    }
    public function getAllColumns()
    {
        return $this->fields->getColumns();
    }

    public function getColumnDescription($column){
        $description = $this->getColumn($column)->description;
        if(isset($description)){
            return $description;
        }
        return $column;
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

    public function getExtendedType($name){
        return false;
    }

    public function getExtendedName($name){
        return "";
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

    protected function getColumn($name){
        foreach($this->getColumns() as $column){
            if($column->get('name') == $name){
                return $column;
            }
        }
    }

    public function getValue($name){
        $column = $this->getColumn($name);
        if($column->type == 'enum'){
            return $column->values[$this->$name];
        }
        if($column->type == 'boolean'){
            return ['0' => '否', '1' => '是'][$this->$name];
        }
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
            }elseif($value['type'] != 'extend'){
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
        if(!in_array($column, $this->extended)){
            $type = $this->getColumn($column)->type;
            foreach(self::all()->groupBy($column) as $key => $item){
                if($type == 'enum'){
                    $value = $this->getColumn($column)->values[$key];
                }elseif($type == 'boolean'){
                    $value = ['0' => '否', '1' => '是'][$key];
                }else{
                    $value = $item[0][$column];
                }
                $data[$key] = $value;
            }
        }else{
            $data = $this->getExtendedValueGroups($column);
        }
        return $data;
    }

    public function getExtendedValueGroups($column){
        return [];
    }

    public function canFilterColumn($column){
        if(in_array($column, $this->filterable)){
            return true;
        }
        return false;
    }

    public function getExtended(){
        return $this->extended;
    }

    public function filter($key, $value, $data){
        return $data;
    }

    public function canListColumn($column){}

    public function canShowColumn($column){}

    public function canCreateColumn($column){}

    public function canEditColumn($column){}

    public function isSwitchable($column){
        if(in_array($column, $this->switchable)){
            return true;
        }
        return false;
    }

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

    public function toArray(){
         $attributes = $this->attributesToArray();
         $arr = array_merge($attributes, $this->relationsToArray());
         foreach($this->relations as $key => $relation){
             unset($arr[$key]);
         }
         return $arr;
    }

    public function getTitle(){
        return $this->title;
    }


}
