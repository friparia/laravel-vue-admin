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

    protected $guarded = [];

    public $timestamps = false;
    protected $fields;
    protected $actions;

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
    }

    public function getColumns()
    {
    }

    public function getListableColumns(){}

    public function getShowableColumns(){}

    public function getEditableColumns(){
        return ['test', 'fuck', 'test2_id'];
    }

    public function getValue($name){}

    public function getRawValue($name){
        return $this->$name;
    }

    public function getAllActions(){
        return ['create', 'update', 'delete'];
    }

    public function getEachActions(){}

    public function getBatchActions(){}

    public function getSingleActions(){}

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


    public function newFromBuilder($attributes = [], $connection = null){
        $model = parent::newFromBuilder($attributes, $connection);
        foreach($this->fields->getCustomRelations() as $key => $customRelation){
            if($customRelation['type'] == 'belongsTo'){
                $relation = $model->belongsTo($key, $customRelation['foreign_key'], 'id', $customRelation['related']);
                $model->{$customRelation['related']} = $relation->getResults();
                $model->setRelation($customRelation['related'], $relation);
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
