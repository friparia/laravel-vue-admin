<?php
namespace Friparia\Admin;

use Illuminate\Database\Schema\Blueprint as LaravelBlueprint;
use Illuminate\Support\Str;

class Blueprint extends LaravelBlueprint
{

    protected $custom_relations = [];

    public function belongsTo($model){
        $related = Str::snake(class_basename($model));
        $foreign_key = $related . "_id";
        $this->custom_relations[$model] = ['type' => 'belongsTo', 'foreign_key' => $foreign_key, 'related' => $related];
        return $this->integer($foreign_key);
    }

    public function hasOne(){
        dd("TODO");
    }

    public function hasMany(){
        dd("TODO");
    }

    public function belongsToMany(){
        dd("TODO");
    }

    public function getCustomRelations(){
        return $this->custom_relations;
    }

}


