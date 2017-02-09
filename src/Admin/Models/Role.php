<?php
namespace Friparia\Admin\Models;
use Friparia\RestModel\Model;
class Role extends Model{

    protected $_listable = ['name'];
    protected $_creatable = ['name'];
    protected $_editable = ['name'];

    protected function configure(){
        $this->addField('string', 'name')->unique()->description("名称");
        $this->addField('string', 'description')->nullable();
        $this->addRelation('many', 'permission', 'Friparia\\Admin\\Models\\Permission');
        $this->addAction('modal', 'add')->single()->color('success')->description("添加");
        $this->addAction('modal', 'edit')->each()->color('info')->description("编辑");
    }

    public function permission(){
        return $this->belongsToMany('Friparia\\Admin\\Models\\Permission');
    }

    public function hasPermission($permission_name){
        foreach($this->permission as $permission){
            if($permission->name == $permission_name){
                return true;
            }
        }
        return false;
    }
}
