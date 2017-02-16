<?php 
namespace Friparia\Admin\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use Illuminate\Http\Request;
use Session;
use Friparia\Admin\Models\User;
use JWTAuth;

class AuthController extends Controller{

    public function signin(Request $request)
    {
        if($token = JWTAuth::getToken()){
            try{
                JWTAuth::invalidate($token);
            }catch(\Exception $e){
            }
        }
        $credentials = $request->only('username', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['success' => false, 'msg' => '用户名或密码错误'], 401);
        }
        return response()->json(['success' => true, 'token' => $token, 'username' => $request->input('username')]);
    }

    public function signout(Request $request){
        if($token = JWTAuth::getToken()){
            try{
                JWTAuth::invalidate($token);
            }catch(\Exception $e){
            }
        }
        return response()->json(['success' => true]);
    }

}
