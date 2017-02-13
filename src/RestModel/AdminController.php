<?php
namespace Friparia\RestModel;

use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Http\Request;
// use Validator;
use Illuminate\Support\Str;
// use App\Models\Log;

class AdminController extends LaravelController{

    public function action(Request $request, $id){
        list($model, $action) = explode(".", Route::currentRouteName());
        dd($model);
    }

    public function index2(Request $request)
    {
        if(in_array($action, $this->actions)){
            if(is_null($id)){
                return $this->$action($request);
            }else{
                return $this->$action($request, $id);
            }
        }

        if($id == null){
            if($action == 'all'){
                return $this->all($request);
            }
        }
        $instance = $this->instance($id);
        if(is_null($instance)){
            $request->session()->flash("error", "结果不存在");
            return back();
        }else{
            if(!$instance->isActionExisit($action)){
                $request->session()->flash("error", '方法不存在');
                return back();
            }

            if($instance->isModalAction($action)){
                $controller = "\\".get_called_class();
                $model_name = Str::snake(class_basename($this->model));
                $view = "admin::".$action;
                if(view()->exists($model_name.".".$action)){
                    $view = $model_name.".".$action;
                }
                return view($view)->with('instance', $instance)->with('controller', $controller);;
            }
            if($action == 'switch'){
                $instance->switch_field($request->input('name'));
                $request->session()->flash("success", '操作成功');
                return;
            }
            $attributes = [];
            if($action == 'update' || $action == 'create'){
                foreach($instance->getEditableFields() as $field){
                    $name = $field->name;
                    $value = $request->input($name);
                    if($field->type == 'boolean'){
                        $value = $value == "on";
                    }
                    if($field->isImage()){
                        if ($request->hasFile($field->name)) {
                            $instance->{$field->name} = time().'_'.$request->file($field->name)->getClientOriginalName();
                            $request->file($field->name)->move($instance->getFileStoragePath($field->name), $instance->{$field->name});
                        }
                    }
                    if(!is_null($value)){
                        $attributes[$name] = $value;
                        $instance->{$name} = $value;
                    }
                }
            }
            $instance->$action();

        }
        $request->session()->flash("success", '操作成功');
        return back();
    }

    public function index(Request $request)
    {
        $data = $instance = $this->instance();
        // foreach ($instance->getFilterableFields() as $field) {
        //     $value = $request->input($field->name);
        //     if ($value != '') {
        //         if ($field->type == 'many') {
        //             $data = $data->whereHas($field->name, function ($query) use ($value) {
        //                 $query->where('id', $value);
        //             });
        //         } else if ($field->isExtended()) {
        //             $data = $instance->filterByField($data, $field, $value);
        //         } else {
        //             $data = $data->where($field->name, $value);
        //         }
        //     }
        // }
        // foreach ($instance->getSearchableFields() as $field) {
        //     $data = $data->where(function ($query) use ($q, $instance, $field) {
        //         foreach ($instance->getSearchableFields() as $field) {
        //             if ($field->type == 'string') {
        //                 $query->orWhere($field->name, 'LIKE', "%" . $q . "%");
        //             }
        //         }
        //     });
        //     if($field->type == 'belong'){
        //         $data = $field->search($data, $instance, $q);
        //     }
        //
        // }
        $data = $data->orderBy('id', 'desc')->paginate(20);
        return response()->json(compact('data'));
    }

    public function filter($data){
        return $data;
    }

    protected function instance($id = null){
        list($model, $name) = explode(".", Route::currentRouteName());
        if(is_null($id)){
            $instance = new $model;
        }else{
            $instance = $model::find($id);
        }
        return $instance;
    }
}
