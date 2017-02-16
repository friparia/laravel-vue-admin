<?php
namespace Friparia\RestModel;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

abstract class Model extends LaravelModel
{

    protected $_name;

    /**
     * List page configurations
     */
    protected $_list_fields = [];
    protected $_search_fields = [];
    protected $_filter_fields = [];

    /**
     * Model fields defenition
     */
    protected $_fields = [];

    /**
     * Model actions
     * Array of actions
     */
    protected $_actions = [];

    /**
     * Model relations
     * Array of relations
     */
    protected $_relations = [];

    protected $_modified = [];

    protected $_errors = [];

    protected $_return = [];

    /**
     * Laravel extensions
     */
    protected $guarded = [];

    protected $_title = "";

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->configure();
        $this->_name = Str::snake(class_basename($this));
    }

    protected function configure(){
    }

    protected function addField($type, $name = ""){
        $field = new Field($type, $name); 
        $fields = $this->_fields;
        $fields[] = $field;
        $this->_fields = $fields;
        return $field;
    }

    protected function addRelation($type, $name, $model){
        if($type == 'belong'){
            $this->addField('integer', $name."_id");
        }
        $relation = new Relation($type, $name, $model);
        $relations = $this->_relations;
        $relations[] = $relation;
        $this->_relations = $relations;
        //TODO $this->addFields();
        return $relation;
    }

    protected function addAction($type, $name){
        $action = new Action($type, $name); 
        $actions = $this->_actions;
        $actions[] = $action;
        $this->_actions = $actions;
        return $action;
    }

    public function getConfiguration(){
        $actions = [];
        foreach($this->_actions as $action){
            $actions[] = $action->toArray();
        }
        $listFields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_list_fields)){
                $listFields[] = $field->toArray();
            }
        }
        return [
            'actions' => $actions,
            'listFields' => $listFields,
        ];
    }

    public function getName(){
        return $this->_name;
    }

    public function getFields()
    {
        return $this->_fields;
    }

    public function getRelations()
    {
        return $this->_relations;
    }

    public function getActions()
    {
        return $this->_actions;
    }

    public function getManyRelations(){
        $relations = [];
        foreach($this->getRelations() as $relation){
            if($relation->isMany()){
                $relations[] = $relation;
            }
        }
        return $relations;
    }

    public function getTitle(){
        return $this->_title;
    }

    public function getDatabaseFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(!$field->isExtended()){
                $fields[] = $field;
            }
        }
        return $fields;
    }

    public function getListFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_list_fields)){
                $fields[] = $field;
            }
        }
        return $fields;
    }

    public function hasEachAction(){
        return (bool)count($this->getEachActions());
    }

    public function isActionExisit($action){
        //@todo
        return in_array($action, $this->getAllActions());
    }

    public function getAction($name){
        foreach($this->_actions as $action){
            if($name == $action->name){
                return $action;
            }
        }
        return false;
    }

    public function getActionFields($name){
        $action = $this->getAction($name);
        $fields = $action->fields;
        $ret = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $fields)){
                $ret[] = $field;
            }
        }
        return $ret;
    }

    public function isModalAction($name){
        if($action = $this->getAction($name)){
            if($action->type == 'modal'){
                return true;
            }
        }
        return false;
    }

    public function getEachActions(){
        $actions = [];
        foreach($this->_actions as $action){
            if($action->isEach()){
                $actions[] = $action;
            }
        }
        return $actions;
    }

    public function getSingleActions(){
        $actions = [];
        foreach($this->_actions as $action){
            if($action->isSingle()){
                $actions[] = $action;
            }
        }
        return $actions;
    }

    public function getFieldByName($name){
        foreach($this->_fields as $field){
            if($field->name == $name){
                return $field;
            }
        }
        foreach($this->_relations as $field){
            if($field->name == $name){
                return $field;
            }
        }
        return false;
    }

    public function getFieldValue($field){
        if($field->type == 'many'){
            $description = [];
            foreach($this->{$field->name} as $element){
                $description[] = $element->getValue($field->getDescriptor());
            }
            return implode(',', $description);
        }
        if($field->type == 'belong'){
            return $this->{$field->name}->getValue($field->getDescriptor());
        }
        if($field->type == 'enum'){
            return $this->getEnumValue($field, $this->{$field->name});
        }
        if($field->type == 'boolean'){
            if($this->{$field->name} == true){
                return "是";
            }
            return "否";
        }
        return $this->{$field->name};
    }

    public function getFilterOptions($field){
        if($field->type == 'enum'){
            return $field->getOptions();
        }
        if($field->type == 'many' || $field->type == 'belong'){
            return $field->getOptions();
        }
        if($field->type == 'boolean'){
            return $field->getOptions();
        }
        return [];
    }

    public function getValue($name){
        return $this->{$name};
    }

    public function getEnumValue($field, $value){
        return $field->getEnumValue($value);
    }

    public function setModified($attributes){
        $this->_modified = $attributes;
    }

    public function getErrors(){
        return $this->_errors;
    }

    public function getReturn(){
        return $this->_return;
    }

    public function create(){
        return parent::create($this->_modified);
    }

    public function update(array $attributes = [], array $options = []){
        return parent::update($this->_modified);
    }

    public function inManyRelation($field, $id){
        if($field->type == 'many'){
            foreach($this->getValue($field->name) as $element){
                if($element->id = $id){
                    return true;
                }
            }
        }
        return false;
    }

    public function filterByField($data, $field, $value){
        return $data;
    }

    //TODO
    public function getFileStoragePath($name){
        if(!isset($this->{$name})){
            throw new \Exception('Invalid File Name, please generate filename first');
        }
        return public_path($this->_name . '/' . $name).$this->{$name};
    }

    public function createMigrationFile(){
        $creator = new MigrationCreator($this);
        $path = database_path().'/migrations';
        $creator->create($this->_name, $path, $this->getTable());
    }
}
