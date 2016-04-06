<?php

namespace Friparia\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected construct(){
        $this->fields->string('name');
        $this->fields->string('email')->unique();
        $this->fields->string('password');
        $this->fields->timestamps();
        $this->fields->relation('role')->hasManyToMany('Friparia\\Admin\\Models\\Role');
    }
}
