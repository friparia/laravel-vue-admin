<?php
/**
 * Created by PhpStorm.
 * User: friparia
 * Date: 16/3/31
 * Time: 00:31
 */

namespace Friparia\Admin;

use Illuminate\Console\Command;
use Hash;

class CreateAdminUserCommand extends Command
{
    protected $signature = "admin:create {username}";

    protected $description = "Create a super admin user account";

    public function handle(){
        $username = $this->argument('username');
        $password = $this->secret("What is the password?");
        $confirm = $this->secret("Please re-enter yout password");
        if($password != $confirm){
            $this->error("Please enter same password!");
        }
        \App\Models\User::create(['name' => $username, 'password' => Hash::make($password)]);
        $this->line("create success!");

    }

}
