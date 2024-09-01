<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlockStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check whether the user is blocked
        if($request->user()->blocked_reason){
            return response()->json([
                "status"=> "blocked",
                "message"=> "User blocked",
                "reason" => "You have been blocked by an administrator"
            ] , 403);
        }

        return $next($request);
    }
}
