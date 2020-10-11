<?php

namespace App\Http\Middleware;

use App\Models\Diary;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = Diary::findOrFail($request->diary)->user_id;
        if ($data == Auth::id()) {
            return $next($request);
        } else {
            return abort('403');
        }
    }
}
