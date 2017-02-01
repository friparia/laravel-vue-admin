<?php

namespace Friparia\Admin\Models;

use Friparia\Admin\Model;
// use PushNotification;

class Message extends Model
{

    protected $_title = "消息推送";
    protected $actions = [
        'add' => [
            'type' => 'url',
            'color' => 'green',
            'single' => true,
            'each' => false,
            'icon' => 'add',
            'description' => '添加',
            'url' => 'message/send'
        ],
        'edit' => [
            'type' => 'url',
            'color' => 'blue',
            'description' => '修改',
            'url' => 'message/edit/'
        ],
    ];

    protected $casts = [
        "filter" => "array" 
    ];

    protected $_listable = ['title', 'content', 'customer', 'updated_at'];

    protected function configure(){
        $this->addField('string', 'title')->description('消息标题');
        $this->addField('dateTime', 'updated_at')->description('更新时间')->extended();
        $this->addField('text', 'content')->description('消息内容');
        // $this->addRelation('many', 'customer', 'App\Models\Customer')->description("昵称")->descriptor('nickname');
        $this->addAction('url', 'add')->single()->color('success')->description('添加');
        $this->addAction('url', 'edit')->each()->color('info')->description('编辑');
    }



    public static function send_system($id, $content, $type = 1, $order_code = null){
        $customer = Customer::find($id);
        if($customer == null){
            return false;
        }
        $push_message = PushNotification::Message($content, ['alert' => $content, 'badge' => $customer->unreadCount(), 'sound' => 'default', 'type' => $type, 'code' => $order_code]);;
        if($customer->device_code != ''){
            PushNotification::app($customer->app_name)->to($customer->device_code)->send($push_message);
            $message = new Message;
            $message->title = "系统推送";
            $message->content = $content;
            $message->save();
            $customer_message = new CustomerMessage;
            $customer_message->customer_id = $id;
            $customer_message->message_id = $message->id;
            $customer_message->save();
        }
    }

    public function getFieldValue($field){
        if($field->name == 'content'){
            return strip_tags($this->content);
        }
        if($field->name == 'updated_at'){
            return date("Y-m-d H:i:s", $this->updated_at);
        }
        return parent::getFieldValue($field);
    }


    public function getCreatedAtAttribute($value){
        return strtotime($value);
    }

    public function getUpdatedAtAttribute($value){
        return strtotime($value);
    }

}
