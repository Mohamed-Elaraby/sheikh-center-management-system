<?php

namespace App\Http\Middleware;

use Closure;

class SelectBranchRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRole(['owner', 'general_manager'])) {
            return redirect()->route('admin.selectBranch');
        }
        return $next($request);
    }
}
