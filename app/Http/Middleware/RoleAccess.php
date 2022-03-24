<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // check in array 
        if (! in_array($request->user()->role, $roles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}
