<?php

namespace Friparia\Admin;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use DB;

class MigrateCommand extends Command
{
    protected $signature = "admin:migrate {model}";

    protected $description = "Create or update database according to the model definition";

    public function handle(){
        $model = $this->argument('model');
        $instance = new $model;
        $instance->createMigrationFile();
    }
}

