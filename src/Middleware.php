<?php
/**
 * Created by PhpStorm.
 * User: friparia
 * Date: 16/3/29
 * Time: 23:12
 */

namespace Friparia\Admin;

use Closure;
use Auth;

class Middleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if (!Auth::check()){
            return redirect()->route('admin.login')
        }
        return $next($request);
    }


}