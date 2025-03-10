<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class is_owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $model, $column = 'user_id')
    {
        // Get the model instance dynamically
        $resource = $request->route($model);

        // Ensure the resource exists and the authenticated user owns it
        if (!$resource || $resource->{$column} !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
