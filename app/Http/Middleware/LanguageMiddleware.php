<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Ja adresē ir iedots ?lang=..., ierakstām to sesijā
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, ['lv', 'en'])) {
                Session::put('locale', $lang);
            }
        }

        // 2. Paņemam valodu no sesijas, ja nav - noklusējuma (lv)
        $locale = Session::get('locale', config('app.locale', 'lv'));
        App::setLocale($locale);

        return $next($request);
    }
}