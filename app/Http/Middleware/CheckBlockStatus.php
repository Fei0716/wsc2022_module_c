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
            $block_message = '';
            switch ($request->user()->blocked_reason){
                case 'spam':
                    $block_message = "You have been blocked for spamming";
                    break;
                case 'cheat':
                    $block_message = "You have been blocked for cheating";
                    break;
                case 'other':
                    $block_message = "You have been blocked by an administrator";
                    break;
                default:break;
            }


            return response()->json([
                "status"=> "blocked",
                "message"=> "User blocked",
                "reason" => $block_message
            ] , 401);
        }

        return $next($request);
    }
}
