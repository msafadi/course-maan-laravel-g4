<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$type)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user(); // Auth::user();
        if (! in_array($user->type, $type)) {
            abort(403);
        }

        return $next($request);
    }
}
