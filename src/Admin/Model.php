<?php
namespace Friparia\Admin;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

abstract class Model extends LaravelModel
{

    protected $_name;
    /**
     * List page configurations
     */
    protected $_listable = [];
    protected $_filterable = [];
    protected $_searchable = [];
    protected $_switchable = [];


    /**
     * Create or edit page  configurations
     */
    protected $_creatable = [];
    protected $_editable = [];

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

    /**
     * Laravel extensions
     */
    protected $guarded = [];

    protected $_title = "";
    /**
     *
     * protected $title = "商户";
    protected $unlistable = ['created_at', 'updated_at', 'deleted_at', 'card'];
    protected $filterable = ['type', 'province', 'city', 'district'];
    protected $searchable = ['name'];
    protected $extended = ['province', 'city', 'district', 'card'];
    protected $switchable = ['is_top', 'is_cooper'];
    protected $order = ['name', 'type', 'province', 'city', 'district', 'is_top', 'is_cooper'];
    public $timestamps = false;
    protected $actions = [
        'edit' => [
            'type' => 'modal',
            'color' => 'blue',
            'description' => '修改',
        ],
        'add' => [
            'type' => 'modal',
            'single' => true,
            'each' => false,
            'color' => 'green',
            'icon' => 'add',
            'description' => '添加',
        ],
        'switch_is_top' => [
            'type' => 'extend',
        ],
        'switch_is_cooper' => [
            'type' => 'extend',
        ],
    ];
    protected function construct(){
        ///////
        //$this->fields->timestamps(); 
        //$this->fields->softDeletes();
        ///////
        $this->fields->string('name')->description('商户名称');
        $this->fields->enum('type',['sport','entertainment','travel','food','other'])->description('商户类型')->values([
            'sport' => '运动',
            'entertainment' => '娱乐',
            'travel' => '旅行',
            'food' => '美食',
            'other' => '其他',
        ]);
        $this->fields->boolean('is_top')->description('置顶');
        $this->fields->boolean('is_cooper')->description('合作');
        $this->fields->relation('district')->belongsTo('App\Models\District')->description("区县");
    }
     */

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->configure();
        $this->_name = Str::snake(class_basename($this));
        // $this->fields = new Blueprint($this->getTable());
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
        return $relation;
    }

    protected function addAction($type, $name){
        $action = new Action($type, $name); 
        $actions = $this->_actions;
        $actions[] = $action;
        $this->_actions = $actions;
        return $action;
    }

    public function createMigrationFile(){
        $creator = new MigrationCreator($this);
        $path = database_path().'/migrations';
        $creator->create($this->_name, $path, $this->getTable());
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

    public function getListableFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_listable)){
                $fields[] = $field;
            }
        }
        foreach($this->_relations as $relation){
            if(in_array($relation->name, $this->_listable)){
                $fields[] = $relation;
            }
        }
        return $fields;
    }

    public function getFilterableFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_filterable)){
                $fields[] = $field;
            }
        }
        foreach($this->_relations as $relation){
            if(in_array($relation->name, $this->_filterable)){
                $fields[] = $relation;
            }
        }
        return $fields;
    }

    public function getCreatableFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_creatable)){
                $fields[] = $field;
            }
        }
        foreach($this->_relations as $relation){
            if(in_array($relation->name, $this->_creatable)){
                $fields[] = $relation;
            }
        }
        return $fields;
    }

    public function getSearchableFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_searchable)){
                $fields[] = $field;
            }
        }
        foreach($this->_relations as $relation){
            if(in_array($relation->name, $this->_searchable)){
                $fields[] = $relation;
            }
        }
        return $fields;
    }

    public function getEditableFields(){
        $fields = [];
        foreach($this->_fields as $field){
            if(in_array($field->name, $this->_editable)){
                $fields[] = $field;
            }
        }
        foreach($this->_relations as $relation){
            if(in_array($relation->name, $this->_editable)){
                $fields[] = $relation;
            }
        }
        return $fields;
    }

    public function hasEachAction(){
        return (bool)count($this->getEachActions());
    }

    public function isActionExisit($action){
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

    public function isModalAction($name){
        if($action = $this->getAction($name)){
            if($action->type == 'modal'){
                return true;
            }
        }
        return false;
    }

    public function getAllActions(){
        $actions = ['create', 'update', 'delete', 'switch'];
        foreach($this->_actions as $action){
            $actions[] = $action->name;
        }
        return $actions;
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

    public function getFileStoragePath($name){
        if(!isset($this->{$name})){
            throw new \Exception('Invalid File Name, please generate filename first');
        }
        return public_path($this->_name . '/' . $name).$this->{$name};
    }


    public function getFilename($name, $extension){
        return  $name . '_' . time() . '.' . $extension;
    }

    public function switch_field($name){
        $this->$name = !$this->$name;
        $this->save();
    }

}
