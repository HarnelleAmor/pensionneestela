<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (User::where('email', $request->email)->exists()) {
            if (User::firstWhere('email', $request->email)->is_archived) {
                return redirect()->route('login')->with('deactivatedAccount', 'Your account is deactivated.');
            }
        }

        return $next($request);
    }
}
