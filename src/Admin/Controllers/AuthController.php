<?php
namespace Friparia\Admin\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{

    protected $redirectAfterLogout = '/admin/auth/signin';

    public function signin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/');
        }
        return back()->withInput()->with('error', '用户名或密码错误');
    }

    public function signout(Request $request){
        return response()->json(['success' => true]);
    }

}
