<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);
        if (in_array($locale, ['en', 'ar'])) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
        } elseif (session()->has('locale')) {
            app()->setLocale(session('locale'));
        } else {
            app()->setLocale('en');
        }
        return $next($request);
    }
}