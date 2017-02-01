<?php

namespace Friparia\Admin\Controllers;
use Friparia\Admin\Models\Feedback;

use Illuminate\Http\Request;
use Friparia\Admin\Controllers\AdminBaseController as BaseController;
class FeedbackController extends BaseController
{
    protected $model = "Friparia\\Admin\\Models\\Feedback";

    protected $actions = ['show'];
    public function show(Request $request, $id){
        $feedback = Feedback::find($id);
        return view('admin::feedback', compact('feedback'));
    }
}


