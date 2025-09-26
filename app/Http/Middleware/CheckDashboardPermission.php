<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDashboardPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->can('view dashboard')) {
            return $next($request);
        }

        if ($user && $user->can('view orders')) {
            return redirect()->route('orders.index');
        } elseif ($user && $user->can('view services')) {
            return redirect()->route('services.index');
        }

        return abort(403, 'Unauthorized');
    }
}
