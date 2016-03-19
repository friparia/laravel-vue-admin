<?php

namespace Friparia\Admin;

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
        $connection = DB::connection();
        $this->model->getFields()->create();
        $connection->useDefaultSchemaGrammar();
        $this->model->getFields()->build($connection, $connection->getSchemaGrammar());

    }


}
