<?php

namespace Friparia\Admin;

use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    protected $signature = "admin:migrate {model}";

    protected $description = "Create or update database according to the model definition";

    public function handle(){
        $model = $this->argument('model');
        if($this->confirm("Ready to migrate $model model")){
            $migrate = new Migrate($model);
            $migrate->migrate();
            $this->line("Migrate success!");
        }
    }
}

