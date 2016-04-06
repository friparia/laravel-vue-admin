<?php
namespace Friparia\Admin\Models;
use Friparia\Admin\Model;
class Role extends Model{
    protected function construct(){
        $this->fields->string('name')->unique();
        $this->fields->string('description')->nullable();
        $this->fields->timestamps();
        $this->fields->relation('user')->belongsToMany('Friparia\\Admin\\Models\\User');
        $this->fields->relation('permission')->hasManyToMany('Friparia\\Admin\\Models\\Permission');
    }
}
