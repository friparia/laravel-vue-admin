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

    protected $fields;

    public function __construct()
    {
        parent::__construct();
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

    public function getCreatableColumns(){}

    public function getEditableColumns(){}

    public function getValue($name){}

    public function getRawValue($name){
        return $this->$name;
    }

    public function getAllActions(){}

    public function getEachActions(){}

    public function getBatchActions(){}

    public function getSingleActions(){}

    public function canListColumn($column){}

    public function canShowColumn($column){}

    public function canCreateColumn($column){}

    public function canEditColumn($column){}

    static public function search($q){}


    public function newFromBuilder($attributes = [], $connection = null){
        $model = parent::newFromBuilder($attributes, $connection);
        foreach($this->fields->getCustomRelations() as $key => $relation){
            if($relation['type'] == 'belongsTo'){
                $model->{$relation['related']} = $model->belongsTo($key, $relation['foreign_key'], 'id', $relation['related'])->getResults();
            }
        }
        return $model;
    }


}
