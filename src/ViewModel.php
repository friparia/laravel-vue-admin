<?php
namespace Friparia\Admin;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ViewModel extends Controller{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function index(Request $request){
        dd($request->segment(2));
    }

}
