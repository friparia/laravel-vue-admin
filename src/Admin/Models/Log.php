<?php

namespace Friparia\Admin\Models;

use Friparia\RestModel\Model;

class Log extends Model
{

    protected $title = "操作日志";

    protected $_listable = ['info', 'user', 'role', 'created_at'];
    protected $_searchable = ['info'];

    protected function configure(){
        $this->addField('string', 'info')->description('操作内容');
        $this->addRelation('belong', 'user', 'Friparia\\Admin\\Models\\User')->description('用户')->descriptor('cname');
        $this->addField('dateTime', 'created_at')->description('操作时间')->extended();
        $this->addField('string', 'role')->extended()->description('用户组');
    }

    public function getFieldValue($field){
        if($field->name == 'role'){
            return $this->user->getFieldValue($this->user->getFieldByName('role'));
        }
        return parent::getFieldValue($field);
    }

    public static function add($info){
        $log = new Log;
        $log->info = $info;
        $log->user_id = \Auth::user()->id;
        $log->save();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function getColumnDescription($name){
    //     if($name == 'user'){
    //         return "用户";
    //     }
    //     if($name == 'user_group'){
    //         return "用户组";
    //     }
    //     if($name == 'created_at'){
    //         return "操作时间";
    //     }
    //     return parent::getColumnDescription($name);
    // }
    //
    // public function getValue($name){
    //     if($name == 'user'){
    //         return $this->user->name;
    //     }
    //     if($name == 'user_group'){
    //         return $this->user->getValue('group');
    //     }
    //     return parent::getValue($name);
    // }

}
