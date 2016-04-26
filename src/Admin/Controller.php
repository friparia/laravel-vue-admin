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
        dd('admin');
    }

    public function adminList(Request $request)
    {
        return view('admin::list');
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
                $value = $request->input($column);
                if(!is_null($value)){
                    $attributes[$column] = $value;
                    $instance->$column = $value;
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
