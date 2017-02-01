<?php 
namespace Friparia\Admin\Controllers;

use Illuminate\Routing\Controller as LaravelController;
use Auth;
use Illuminate\Http\Request;
use Session;
use Friparia\Admin\Models\User;

class AuthController extends LaravelController{

    public function signin(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        if(true){
            return response()->json(['success' => true, 'token' => '1']);
        }
        return response()->json(['success' => false, 'msg' => 'fuck']);
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect("/admin/auth/login")->withInput()->with('error', "注销成功！");
    }

    public function forget(Request $request){
        return view('admin::forget');
    }

    public function changePassword(Request $request){
        $captcha = $request->input('captcha');
        if($request->input('name') != Session::get('username')){
            return redirect("/admin/auth/forget")->withInput()->with('error', "别想改用户名!");
        }
        if($captcha != Session::get('captcha')){
            return redirect("/admin/auth/forget")->withInput()->with('error', "验证码错误!");
        }
        if($request->input('password') != $request->input('password-confirm')){
            return redirect("/admin/auth/forget")->withInput()->with('error', "密码两次错误!");
        }
        $user = User::where('name', $request->input('name'))->first();
        $user->password = \Hash::make($request->input('password'));
        $user->save();

        return redirect("/admin/auth/login")->withInput()->with('error', "密码修改成功，请重新登录");
    }
}
