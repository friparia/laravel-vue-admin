<?php
namespace Friparia\RestModel;

use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator; 
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MigrationCreator extends LaravelMigrationCreator{

    protected $_model;
    public function __construct($model){
        $this->_model = $model;
        parent::__construct(new Filesystem());
    }

    protected function getStub($table, $create){
        return $this->files->get(__DIR__.'/../resources/stubs/migration.stub');
    }

    protected function populateStub($name, $stub, $table){
        $stub = parent::populateStub($name, $stub, $table);
        $columns = [];
        foreach($this->_model->getDatabaseFields() as $field){
            if($description = $field->getMigrationDescription()){
                list($method, $name, $parameters, $functions) = $description;
                $columns[] = $this->populateColumnStub($method, $name, $parameters, $functions);
            }
        }
        $stub = str_replace('DummyColumns', implode("", $columns), $stub);
        $relations = $this->_model->getManyRelations();
        $stub = str_replace('DummyRelationCreateSchema', $this->populateRelationCreateStub($relations), $stub);
        $stub = str_replace('DummyRelationDropSchema', $this->populateRelationDropStub($relations), $stub);
        return $stub;
    }

    protected function populateColumnStub($method, $name, $parameters, $functions){
        $stub = $this->files->get(__DIR__.'/../resources/stubs/column.stub');
        $stub = str_replace('DummyMethod', $method, $stub);
        $stub = str_replace('DummyName', $name, $stub);
        if(empty($parameters)){
            $stub = str_replace('DummyParameters', "", $stub);
        }else{
            $parameters = implode(", ", $parameters);
            $stub = str_replace('DummyParameters', ", ".$parameters, $stub);
        }
        if(empty($functions)){
            $stub = str_replace('DummyFunctions', "", $stub);
        }else{
            $functions_chain = "";
            foreach($functions as $name => $parameters){
                if(empty($parameters)){
                    $functions_chain .= "->$name()";
                }else{
                    $function_parameter = implode(",", $parameters);
                    $functions_chain .= "->$name($function_parameter)";
                }
            }
            $stub = str_replace('DummyFunctions', $functions_chain, $stub);
        }
        return $stub;
    }

    protected function populateRelationCreateStub($relations){
        if(empty($relations)){
            return "";
        }
        $schemas = [];
        foreach($relations as $relation){
            $stub = $this->files->get(__DIR__.'/../resources/stubs/create_schema.stub');
            $table = $this->getRelationTable($this->_model->getTable(), $relation->name);
            $stub = str_replace('DummyTable', $table, $stub);
            foreach([$this->_model->getName(), $relation->name] as $name){
                $columns[] = $this->populateColumnStub('integer', $name."_id", [], ['index' => []]);
            }
            $stub = str_replace('DummyColumns', implode("", $columns), $stub);
            $schemas[] = $stub;
        }
        return implode("\n", $schemas);
    }

    protected function populateRelationDropStub($relations){
        if(empty($relations)){
            return "";
        }
        $schemas = [];
        foreach($relations as $relation){
            $stub = $this->files->get(__DIR__.'/../resources/stubs/drop_schema.stub');
            $table = $this->getRelationTable($this->_model->getTable(), $relation->name);
            $stub = str_replace('DummyTable', $table, $stub);
            $schemas[] = $stub;
        }
        return implode("\n", $schemas);
    }

    protected function getRelationTable($first, $second){
        $arr = [Str::singular($first), $second];
        sort($arr);
        $table = implode("_", $arr);
        return $table;
    }
}
