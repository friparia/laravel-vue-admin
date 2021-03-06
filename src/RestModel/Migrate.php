<?php

namespace Friparia\RestModel;

use DB;

class Migrate
{
    /** @var Model */
    protected $model;

    /** @var  \Illuminate\Database\Connection */
    protected $connection;

    /**
     * Migrate constructor.
     * @param $model
     */
    public function __construct($model){
        $this->model = new $model;
    }

    /**
     *
     */
    public function migrate()
    {
        $this->model->createMigrationFile();
        //call migrate
        // $connection = DB::connection();
        // $connection->useDefaultSchemaGrammar();
        // foreach($this->model->getManyRelations() as $relation){
        //     $blueprint = new Blueprint($relation['table']);
        //     $blueprint->increments("id");
        //     $blueprint->integer($relation['foreignKey']);
        //     $blueprint->integer($relation['otherKey']);
        //     $blueprint->create();
        //     $blueprint->build($connection, $connection->getSchemaGrammar());
        // }
        // $this->model->getFields()->create();
        // $this->model->getFields()->build($connection, $connection->getSchemaGrammar());

    }


}
