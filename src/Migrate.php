<?php

namespace Friparia\Admin;


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
        $table = "test_table";
        foreach ($this->model->getFields() as $field) {
        }
    }


}
