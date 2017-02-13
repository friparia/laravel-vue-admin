<?php
namespace Friparia\RestModel;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
// use Validator;
use Illuminate\Support\Str;
// use App\Models\Log;

class AdminController extends Controller{

    public function action(Request $request, $id = null){
        list($model, $action) = explode(".", Route::currentRouteName());
        $instance = $this->instance($id);
        if(is_null($instance)){
            return response()->json(['success' => false, 'msg' => "结果不存在"]);
        }
        $fields = $instance->getActionFields($action);
        $attributes = [];
        foreach($fields as $field){
            $name = $field->name;
            if($field->type == 'boolean'){
                $value = $request->has($name);
            }else{
                $value = $request->input($name);
            }
            if(!is_null($value)){
                $attributes[$name] = $value;
            }
        }
        $instance->setModified($attributes);
        if($instance->$action()){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false, 'msg' => $instance->getErrors()]);
        }
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
