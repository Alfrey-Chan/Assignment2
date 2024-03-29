<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // User is not authenticated
            return redirect('login');
        }

        $user = Auth::user();
        if (!$user->isAdmin()) {
            return back()->withErrors(
                'You do not have permission to access the page requested.'
            );
        }

        // User is authenticated and is an admin
        return $next($request);
    }
}
