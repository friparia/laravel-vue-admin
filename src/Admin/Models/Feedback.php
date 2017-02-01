<?php

namespace Friparia\Admin\Models;

use Friparia\Admin\Model;

class Feedback extends Model
{
    protected $title = "用户反馈";

    protected $_listable = ['type', 'is_read', 'content', 'customer', 'cellphone'];
    protected $_editable = ['is_read'];
    protected $_searchable = ['customer'];

    protected $_filterable = ['is_read', 'type'];

    protected function configure(){
        $this->addField('enum', 'type', ['other', 'auth', 'post', 'task', 'extract'])->description('反馈类型')->values(['auth' => '认证问题', 'other' => '其他问题', 'post' => '发布问题', 'task' => '任务问题', 'extract' => '提现问题']);
        $this->addField('text', 'content')->description('反馈内容');
        $this->addRelation('belong', 'customer', 'App\\Models\\Customer')->descriptor("nickname")->description("用户昵称")->searchFields('nickname', 'cellphone');
        $this->addField('dateTime', 'created_at')->description('提交时间')->extended();
        $this->addField('dateTime', 'created_at')->description('提交时间')->extended();
        $this->addField('boolean', 'is_read')->description("是否已读");
        $this->addField('string', 'cellphone')->description("联系方式")->extends();
        $this->addAction('modal', 'show')->each()->color('info')->description('查看');
    }

    public function customer(){
        return $this->belongsTo(\App\Models\Customer::class);
    }

    public function getFieldValue($field){
        if($field->name == 'cellphone'){
            return $this->customer->cellphone;
        }
        return parent::getFieldValue($field);
    }

}
