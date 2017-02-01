<?php
namespace Friparia\Admin\Controllers;

use Illuminate\Routing\Controller as LaravelController;
// use Route as LaravelRoute;
use Illuminate\Http\Request;
// use Validator;
use Illuminate\Support\Str;
// use App\Models\Log;

class AdminController extends LaravelController{

    protected $actions = [];
    public function index(Request $request, $action, $id = null)
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

    public function add(Request $request){
        $instance = $this->instance();
        $controller = "\\".get_called_class();
        return view('admin::add', compact('instance', 'controller'));
    }

    public function all(Request $request)
    {
        $data = $instance = $this->instance();
        $q = $request->input('q');
        foreach ($instance->getFilterableFields() as $field) {
            $value = $request->input($field->name);
            if ($value != '') {
                if ($field->type == 'many') {
                    $data = $data->whereHas($field->name, function ($query) use ($value) {
                        $query->where('id', $value);
                    });
                } else if ($field->isExtended()) {
                    $data = $instance->filterByField($data, $field, $value);
                } else {
                    $data = $data->where($field->name, $value);
                }
            }
        }
        foreach ($instance->getSearchableFields() as $field) {
            $data = $data->where(function ($query) use ($q, $instance, $field) {
                foreach ($instance->getSearchableFields() as $field) {
                    if ($field->type == 'string') {
                        $query->orWhere($field->name, 'LIKE', "%" . $q . "%");
                    }
                }
            });
            if($field->type == 'belong'){
                $data = $field->search($data, $instance, $q);
            }

        }
        $data = $this->filter($data);
        $data = $data->orderBy('id', 'desc')->paginate(20);
        $controller = "\\".get_called_class();
        return view('admin::all', compact('data', 'instance', 'controller'));
    }

    public function filter($data){
        return $data;
    }


    protected function instance($id = null){
        $model = $this->model;
        if(is_null($id)){
            $instance = new $model([]);
        }else{
            $instance = $model::find($id);
        }
        return $instance;
    }
}
