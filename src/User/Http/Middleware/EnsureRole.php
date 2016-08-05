<?php

namespace Modules\User\Http\Middleware;

use Auth;
use Closure;

/**
 * Class EnsureRole
 * @package Modules\User\Http\Middleware
 */
class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param $value
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $value)
    {
        if (!Auth::user()->hasRole($value)) {
            app()->abort(403, 'Missing role \''.$value.'\'');
        }

        return $next($request);
    }
}
