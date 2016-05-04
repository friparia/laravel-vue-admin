<?php

namespace Friparia\Admin\Models;

use Friparia\Admin\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected function construct(){
        $this->fields->string('name');
        $this->fields->string('email')->unique();
        $this->fields->string('password');
        $this->fields->boolean('is_admin')->default(false);
        $this->fields->timestamps();
        $this->fields->rememberToken();
        $this->fields->relation('role')->hasManyToMany('Friparia\\Admin\\Models\\Role');
    }
}
