<?php
namespace Friparia\Admin\Models;
use Friparia\RestModel\Model;
class Permission extends Model{

    protected function configure(){
        $this->addField('string', 'name')->unique();
        $this->addField('description')->nullable();
    }

}
