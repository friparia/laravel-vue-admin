<?php
namespace Friparia\Admin;

use Route as LaravelRoute;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Http\Request;
use Validator;

class Controller extends LaravelController
{


    protected $model;

    public function index($action, $id = null)
    {
        dd($action, $id);
    }

    public function admin(Request $request, $action, $id = null)
    {
        $instance = $this->initInstance($id);
        if(is_null($instance)){
            $request->session()->flash("error", "结果不存在");
            return response()->json();
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
                $request->session()->flash("error", $validator->errors());
                return response()->json();
            }
            if(!in_array($action, $instance->getAllActions())){
                $request->session()->flash("error", '方法不存在');
                return response()->json();
            }

            if(in_array($action, $instance->getModalActions())){
                $controller = "\\".get_called_class();
                return view("admin::".$action)->with('instance', $instance)->with('controller', $controller);;
            }
            $attributes = [];
            foreach($instance->getEditableColumns() as $column){
                $value = $request->input($column->name);
                if(!is_null($value)){
                    $attributes[$column->name] = $value;
                    $instance->{$column->name} = $value;
                }
            }
            if($action == 'create'){
                $instance->$action($attributes);
            }else{
                $instance->$action();
            }

        }
        $request->session()->flash("success", '操作成功');
        return response()->json();
    }

    public function adminList(Request $request)
    {
        $instance = $this->initInstance();
        $data = $instance->paginate(20);
        $controller = "\\".get_called_class();
        return view('admin::list', compact('data', 'instance', 'controller'));
    }

    public function adminShow(Request $request, $action)
    {
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
                $value = $request->input($column->name);
                if(!is_null($value)){
                    $attributes[$column->name] = $value;
                    $instance->{$column->name} = $value;
                }
            }
            if($action == 'create'){
                $result = ['status' => true, 'item' => $instance->$action($attributes)];
            }else{
                if($return = $instance->$action()){
                    $result = array_merge(['status' => true], $return);
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
