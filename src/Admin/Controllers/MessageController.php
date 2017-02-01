<?php

namespace Friparia\Admin\Controllers;
use Friparia\Admin\Models\Message;
use Illuminate\Http\Request;
use App\Models\Customer;
// use PushNotification;

use Friparia\Admin\Controllers\AdminBaseController as BaseController;
class MessageController extends BaseController
{
    protected $model = "Friparia\\Admin\\Models\\Message";
    protected $actions = ['add', 'create', 'edit', 'update','uploadpic'];

    public function add(Request $request){
        return view('admin::message-add');
    }

    public function edit(Request $request, $id){
        return view('admin::message-edit')->with('message', Message::find($id));
    }

    public function update(Request $request, $id){
        $input = \Request::input();
        $message = Message::find($id);
        if(isset($input['title'])){
            $message->title = $input['title'];
        }
        if(isset($input['content'])){
            $message->content = $input['content'];
        }
        $message->save();
        $request->session()->flash('success', '修改成功');
        return redirect('/admin/message/all');
    }

    public function create(Request $request){
        $content = $request->input('content');
        $message = new Message;
        $message->title = $request->input('title');
        $message->content = $content;
        // $message->is_system = false;
        $message->save();
        $customers = Customer::all();
        foreach($customers as $customer){
            if($request->input('gender') != ""){
                if($customer->gender != $request->input('gender')){
                    continue;
                }
            }
            if($request->input('city_id') !=""){
                if($customer->college->district->city_id != $request->input('city_id')){
                    continue;
                }
            }

            // $push_message = PushNotification::Message(strip_tags($content), ['alert' => $content, 'badge' => $customer->unreadCount(), 'sound' => 'default', 'type' => 1, 'code' => null]);;
            if($customer->device_code != ''){
                // PushNotification::app($customer->app_name)->to($customer->device_code)->send($push_message);
                $customer->messages()->attach($message->id);
            }
        }
        $request->session()->flash('success', '发送成功');
        return redirect('/admin/message/all');
    }

}

