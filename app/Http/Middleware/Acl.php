<?php

namespace App\Http\Middleware;

use App\Functionality;
use Closure;
use Illuminate\Support\Facades\DB;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $functionality, $role, $role2 = '')
    {
        $user = \App\User::find(1);//$request->user();
        $functionality = Functionality::where('key', $functionality)->first();

        $profile_functionality = DB::table('profile_functionalities')
                                   ->where('profile_id', $user->profile_id)
                                   ->where('functionality_id', $functionality->id)
                                   ->first();

        if (!$this->check($profile_functionality->access_type, $role, $role2)) {
            return response()->json('forbidden', 403);
        }

        return $next($request);
    }

    public function check($access, $role, $role2 = '')
    {
        if ($access == 'NO_ACCESS') {
            return false;
        } else if($access == 'FREE_ACCESS') {
            return true;
        } else if($access == 'READ_ACCESS') {
            if ($role2 == 'w') {
                return false;
            } else {
                return true;
            }
        }
    }
}
