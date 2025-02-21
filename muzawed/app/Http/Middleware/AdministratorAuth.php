<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministratorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Filament::auth()->user();

        // if the user isn't filament user (aka admin/developer "us"). user won't get to access
        if (!$user || !User::where('id', $user->id)->whereNotNull('password')->exists()) {
            abort(403);
        }
        // if user is, request is approved
        return $next($request);
    }
}
