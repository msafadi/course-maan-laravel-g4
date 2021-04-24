<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*$lang = $request->query('lang', Session::get('lang', App::getLocale()) );
        
        Session::put('lang', $lang);
        App::setLocale($lang);*/

        $lang = $request->route('locale');

        URL::defaults([
            'locale' => $lang,
        ]);
        Route::current()->forgetParameter('locale');

        App::setLocale($lang);

        return $next($request);
    }
}
