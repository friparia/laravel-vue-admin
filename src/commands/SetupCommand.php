<?php

namespace Friparia\Admin;
use Friparia\RestModel\Migrator;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    protected $signature = "admin:setup";

    protected $description = "set up admin with role based access control";

    public function handle(){
        $migrator = new Migrator(new \Friparia\Admin\Models\User);
        $migrator->createMigrationFile();
        $migrator = new Migrator(new \Friparia\Admin\Models\Role);
        $migrator->createMigrationFile();
        $migrator = new Migrator(new \Friparia\Admin\Models\Permission);
        $migrator->createMigrationFile();
        $this->line("create success!");
    }

}
