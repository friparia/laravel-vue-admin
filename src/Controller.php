<?php
namespace Friparia\Admin;

use Route as LaravelRoute;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class Controller extends LaravelController
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $model;

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function index($action, $id = null)
    {
        dd($action, $id);
    }

    public function admin(Request $request, $action, $id = null)
    {
    }

    public function login(Request $request){
        return view('admin::login');
    }

    public function adminIndex(Request $request){
    }


    public function dologin(Request $request)
    {
        $name = $request->input('username');
        $password = $request->input('password');
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            return redirect("/admin/");
        }
        return redirect("/admin/auth/login")->withInput()->with('error', "用户名或密码错误");
    }

    final public function logout(Request $request){
    }

    public function api(Request $request, $action, $id = null){
        $instance = $this->initInstance($id);
        if(is_null($instance)){
            return response()->json(['status' => false, 'msg' => "Item Not Found"]);
        }else{
            $validator = Validator::make($request->all(), $instance->getRules(), $instance->getValidatorMessages());
            $validator->after(function($validator) use ($instance){
                foreach ($instance->getCustomValidatorCallback() as $callback) {
                    if (!$callback()) {
                        //TODO
                    }
                }
            });
            if($validator->fails()){
                return response()->json(['status' => false, 'msg' => $validator->errors()]);
            }
            if(!in_array($action, $instance->getAllActions())){
                return response()->json(['status' => false, 'msg' => 'Action Not Found']);
            }

            $attributes = [];
            foreach($instance->getEditableColumns() as $column){
                $value = $request->input($column);
                if(!is_null($value)){
                    $attributes[$column] = $value;
                    $instance->$column = $value;
                }
            }
            if($action == 'create'){
                $result = ['status' => true, 'item' => $instance->$action($attributes)];
            }else{
                if($instance->$action()){
                    $result = ['status' => true];
                }
            }

        }
        return response()->json($result);
    }

    public function apiList()
    {
        $instance = $this->initInstance();
        return $instance->all();
    }

    public function apiShow($id){
        $instance = $this->initInstance($id);
        if(is_null($instance)){
            $result = ['status' => false];
        }else{
            $result = $instance;
        }
        return response()->json($result);
    }

    protected function initInstance($id = null){
        $model = $this->model;
        if(is_null($id)){
            $instance = new $model([]);
        }else{
            $instance = $model::find($id);
        }
        return $instance;
    }


    public function batch($action){
    }


}
