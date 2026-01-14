<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommitteeAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('committee')->check()) {
            return redirect()->route('committee.login')
                ->with('error', 'Please login as committee first.');
        }

        return $next($request);
    }
}