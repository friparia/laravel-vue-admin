<?php

namespace Friparia\Admin\Controllers;

use Friparia\Admin\Controllers\AdminBaseController as BaseController;
use Friparia\Admin\Models\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends BaseController
{
    protected $model = 'Friparia\\Admin\\Models\\User';

    protected $actions = ['create', 'update'];

    public function update(Request $request, $id){
        $input = \Request::input();
        $user = User::find($id);
        if(!isset($input['cname'])){
            \Request::session()->flash("error", "请输入员工姓名");
            return back();
        }
        if(!isset($input['password']) || !isset($input['confirm_password'])){
        }else{
            if($input['password'] != $input['confirm_password']){
                \Request::session()->flash("error", "两次密码输入不同");
                return back();
            }else{
                if($input['password'] != ""){
                    $user->password = \Hash::make($input['password']);
                }
            }
        }
        if(isset($input['cellphone'])){
            $user->cellphone = $input['cellphone'];
        }
        $user->cname = $input['cname'];
        $user->save();
        if(isset($input['role'])){
            $data = [];
            foreach($input['role'] as $key => $value){
                if($value == 'on'){
                    $data[] = $key;
                }
            }
            $user->role()->sync($data);
        }else{
            $user->role()->sync([]);
        }
        $user->save();
        \Request::session()->flash("success", '操作成功');
        return back();
    }

    public function create(Request $request){
        $input = \Request::input();
        $user = new User;
        if(!isset($input['name'])){
            \Request::session()->flash("error", "请输入用户名");
            return back();
        }
        if(!isset($input['cname'])){
            \Request::session()->flash("error", "请输入员工姓名");
            return back();
        }
        if(!isset($input['password']) || !isset($input['confirm_password'])){
            \Request::session()->flash("error", "请输入员工密码");
            return back();
        }
        if($input['password'] != $input['confirm_password']){
            \Request::session()->flash("error", "两次密码输入不同");
            return back();
        }
        if(isset($input['cellphone'])){
            $user->cellphone = $input['cellphone'];
        }
        $user->name = $input['name'];
        $user->cname = $input['cname'];
        $user->password = \Hash::make($input['password']);
        // ----------- TAT -----------
        if(Auth::user()->is_manager){
            $user->is_manager = true;
        }elseif(Auth::user()->is_trader){
            $user->trader_id = Auth::user()->id;
        }
        // ----------------------
        $user->save();
        if(isset($input['role'])){
            $data = [];
            foreach($input['role'] as $key => $value){
                if($value == 'on'){
                    $data[] = $key;
                }
            }
            $user->role()->sync($data);
        }else{
            $user->role()->sync([]);
        }
        $user->save();
        \Request::session()->flash("success", '操作成功');
        return back();
    }

    // ----------- TAT -----------
    public function filter($data){
        if(Auth::user()->is_trader){
            $data = $data->where('trader_id', Auth::user()->id)->where('is_trader', '=', 0);
        }
        return $data;
    }
    // ---------------
}


